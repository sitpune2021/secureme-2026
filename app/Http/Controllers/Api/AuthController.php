<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\EmergencyGroup;
use App\Models\EmergencyGroupMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_role' => 'required|string',
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password'  => 'required|string|min:8',
            'phone_no'  => ['required', 'string', 'min:10', 'unique:users,phone_no'],
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $image      = $request->file('image');
                $imageName  = uniqid('user_') . '_' . time() . '.' . $image->getClientOriginalExtension();
                $uploadPath = public_path('admin-assets/img/users');

                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $image->move($uploadPath, $imageName);
                $imagePath = $imageName;
            }

            $user = User::create([
                'user_role'         => $request->user_role,
                'name'              => $request->name,
                'email'             => strtolower($request->email),
                'password'          => Hash::make($request->password),
                'phone_no'          => $request->phone_no,
                'profile_image'     => $imagePath,
            ]);

            $token = $user->createToken('auth_api_token')->plainTextToken;
            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Account created successfully',
                'data'    => [
                    'token' => $token,
                    'user'  => [
                        'id'        => $user->id,
                        'name'      => $user->name,
                        'email'     => $user->email,
                        'phone_no'  => $user->phone_no,
                        'user_role' => $user->user_role,
                        'profile_image'     => $user->profile_image ? url('admin-assets/img/users/' . $user->profile_image) : null,
                    ]
                ]
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::critical("User Registration Failure", [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Registration failed due to a system error.'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();
        $user = User::where('email', strtolower(trim($validated['email'])))->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        try {
            $user->tokens()->delete();
            $token = $user->createToken('auth_api_token')->plainTextToken;

            return response()->json([
                'status'  => true,
                'message' => 'Login successful',
                'data'    => [
                    'token' => $token,
                    'user'  => $user->only(['id', 'name', 'email', 'user_role', 'phone_no']),
                ],
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred during the login process.',
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'User not found or unauthenticated.',
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'Profile retrieved successfully',
                'data'   => [
                    'user' => $user->only(['id', 'name', 'email', 'user_role', 'phone_no', 'created_at']),
                ],
            ], 200);
        } catch (\Throwable $e) {
            Log::error("Profile Fetch Error: " . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'An error occurred while fetching the profile.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $token = $user ? $user->currentAccessToken() : null;
            if ($token && method_exists($token, 'delete')) {
                $token->delete();
            }

            return response()->json([
                'status' => true,
                'message' => 'Successfully logged out from current session.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error logging out : ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while logging out. Please try again later.'
            ], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $user = User::firstOrCreate(
                ['email' => $request->email],
                ['name' => 'User']
            );

            $otp = random_int(100000, 999999);

            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
            ]);

            Mail::to($user->email)->send(new OtpMail($otp));

            return response()->json([
                'status' => true,
                'message' => 'OTP sent to email'
            ]);
        } catch (\Throwable $th) {
            Log::error('Error verifying OTP: ' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while sending OTP. Please try again later.'
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp'   => 'required|digits:6'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if (
                $user->otp !== $request->otp ||
                now()->greaterThan($user->otp_expires_at)
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired OTP'
                ], 401);
            }

            $user->update([
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                // 'user' => $user
                'user'  => $user->only(['id', 'name', 'email', 'user_role', 'phone_no']),
            ]);
        } catch (\Throwable $th) {
            Log::error('Error verifying OTP: ' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while verifying OTP. Please try again later.'
            ], 500);
        }
    }

    public function getUserRole(Request $request)
    {
        try {
            return response()->json([
                'status' => true,
                'user_role' => $request->user()->user_role
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error fetching user role: ' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching user role. Please try again later.'
            ], 500);
        }
    }

    public function getUserProfile(Request $request)
    {
        try {
            $user = $request->user();
            return response()->json([
                'status' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_no' => $user->phone_no,
                    'user_role' => $user->user_role,
                    'profile_image' => $user->profile_image ? url($user->profile_image) : null,
                ]
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error fetching user profile: ' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching user profile. Please try again later.'
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            $validator = Validator::make($request->all(), [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email,' . $user->id,
                'phone_no' => 'required|string|min:10|unique:users,phone_no,' . $user->id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $user->update([
                'name'     => $request->name,
                'email'    => strtolower($request->email),
                'phone_no' => $request->phone_no,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'userId' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_no' => $user->phone_no,
                    'user_role' => $user->user_role
                ]
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Update profile error: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while updating profile'
            ], 500);
        }
    }

    public function userContacts(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $contacts = User::whereIn('user_role', ['police', 'Manager', 'Gym_Person'])
                ->select('id', 'user_role', 'name', 'email', 'phone_no')
                ->paginate($perPage);

            return response()->json([
                'status' => true,
                'data' => $contacts->items(),
                'pagination' => [
                    'current_page' => $contacts->currentPage(),
                    'per_page'     => $contacts->perPage(),
                    'total'        => $contacts->total(),
                    'last_page'    => $contacts->lastPage(),
                    'has_more'     => $contacts->hasMorePages(),
                ]
            ], 200);
        } catch (\Throwable $th) {
            dd($th);
            Log::error('Error fetching user contacts: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching user contacts. Please try again later.'
            ], 500);
        }
    }

    public function userAddContacts(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_role' => 'required|string|in:police,Manager,Gym_Person',
                'name'      => 'required|string|max:255',
                'email'     => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
                'phone_no'  => ['required', 'string', 'min:10', 'unique:users,phone_no'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $validated = $validator->validated();

            $contact = User::create([
                'user_role' => $validated['user_role'],
                'name'      => $validated['name'],
                'email'     => strtolower($validated['email']),
                'password'  => Hash::make('defaultpassword'),
                'phone_no'  => $validated['phone_no'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Contact added successfully',
                'data' => [
                    'id'        => $contact->id,
                    'user_role' => $contact->user_role,
                    'name'      => $contact->name,
                    'email'     => $contact->email,
                    'phone_no'  => $contact->phone_no,
                ]
            ], 201);
        } catch (\Throwable $th) {
            Log::error('Error adding contact: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while adding contact. Please try again later.'
            ], 500);
        }
    }

    public function updateContact(Request $request, $id)
    {
        try {
            $contact = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'user_role' => 'required|string|in:police,Manager,Gym_Person',
                'name'      => 'required|string|max:255',
                'email'     => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email,' . $contact->id],
                'phone_no'  => ['required', 'string', 'min:10', 'unique:users,phone_no,' . $contact->id],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $validated = $validator->validated();

            $contact->update([
                'user_role' => $validated['user_role'],
                'name'      => $validated['name'],
                'email'     => strtolower($validated['email']),
                'phone_no'  => $validated['phone_no'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Contact updated successfully',
                'data' => [
                    'id'        => $contact->id,
                    'user_role' => $contact->user_role,
                    'name'      => $contact->name,
                    'email'     => $contact->email,
                    'phone_no'  => $contact->phone_no,
                ]
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error updating contact: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating contact. Please try again later.'
            ], 500);
        }
    }

    public function deleteContact($id)
    {
        try {
            $contact = User::findOrFail($id);
            $contact->delete();

            return response()->json([
                'status' => true,
                'message' => 'Contact deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error deleting contact: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting contact. Please try again later.'
            ], 500);
        }
    }

    public function createGroup(Request $request)
    {
        try {
            $request->validate([
                'group_name' => 'required|string|max:255',
                'group_type' => 'required|in:police,helper,gym,mixed',
                'description' => 'nullable|string'
            ]);

            $group = EmergencyGroup::create([
                'owner_id'   => $request->user()->id,
                'group_name' => $request->group_name,
                'group_type' => $request->group_type,
                'description' => $request->description,
            ]);

            EmergencyGroupMember::create([
                'group_id' => $group->id,
                'user_id'  => $request->user()->id,
                'role'     => 'owner',
                'status'   => 'approved',
                'joined_at' => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Group created successfully',
                'data'   => $group
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating group: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating group. Please try again later.'
            ], 500);
        }
    }
    public function joinGroup($groupId, Request $request)
    {
        try {

            EmergencyGroupMember::firstOrCreate([
                'group_id' => $groupId,
                'user_id'  => $request->user()->id
            ], [
                'status' => 'pending'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Join request sent'
            ]);
        } catch (\Throwable $th) {
            Log::error('Error joining group: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while joining group. Please try again later.'
            ], 500);
        }
    }
    public function approveMember($groupId, $userId)
    {
        try {
            EmergencyGroupMember::where([
                'group_id' => $groupId,
                'user_id'  => $userId
            ])->update([
                'status' => 'approved',
                'joined_at' => now()
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Member approved'
            ]);
        } catch (\Throwable $th) {
            Log::error('Error joining group: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while approving member. Please try again later.'
            ], 500);
        }
    }
}
