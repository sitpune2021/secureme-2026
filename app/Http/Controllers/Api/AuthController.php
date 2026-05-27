<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Community;
use App\Models\EmergencyGroup;
use App\Models\EmergencyGroupMember;
use App\Models\EmergencyResponse;
use App\Models\EmergencySignal;
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
            'user_role' => 'required|string|in:Police,Gym_Person,General_User,Defense,User',
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password'  => 'required|string|min:8',
            'phone_no'  => ['required', 'string', 'min:10', 'unique:users,phone_no'],
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'fcm_token' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid('user_') . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('admin-assets/img/users'), $imageName);
                $imagePath = $imageName;
            }

            $user = User::create([
                'user_role'     => $request->user_role,
                'name'          => $request->name,
                'email'         => strtolower($request->email),
                'password'      => Hash::make($request->password),
                'phone_no'      => $request->phone_no,
                'profile_image' => $imagePath,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,
                'fcm_token'     => $request->fcm_token,
            ]);

            $token = $user->createToken('auth_api_token')->plainTextToken;
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Account created with location data',
                // 'data' => ['token' => $token, 'user' => $user]
                'data'    => [
                    'token' => $token,
                    'user'  => [
                        'id'        => $user->id,
                        'name'      => $user->name,
                        'email'     => $user->email,
                        'phone_no'  => $user->phone_no,
                        'user_role' => $user->user_role,
                        'fcm_token'     => $user->fcm_token,
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
        try {

            $validator = Validator::make($request->all(), [

                'email'    => 'required|email',
                'password' => 'required|min:6',

            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = strtolower(trim($request->email));

            $user = User::where('email', $email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }

            if (!$user->is_active) {

                return response()->json([
                    'status' => false,
                    'message' => 'Your account is inactive'
                ], 403);
            }

            // Remove old tokens
            $user->tokens()->delete();

            // Generate new token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([

                'status' => true,
                'message' => 'Login successful',

                'data' => [

                    'token' => $token,

                    'user' => [

                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone_no' => $user->phone_no,
                        'user_role' => $user->user_role,
                        'profile_image' => $user->profile_image
                            ? url('admin-assets/img/users/' . $user->profile_image)
                            : null,
                    ]
                ]

            ], 200);

        } catch (\Throwable $e) {

            Log::error('Login Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
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

            $email = strtolower(trim($request->email));

            $user = User::where('email', $email)->first();

            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $otp = random_int(100000, 999999);

            $user->update([

                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(5),

            ]);

            Mail::to($user->email)->send(new OtpMail($otp));

            return response()->json([

                'status' => true,
                'message' => 'OTP sent successfully'

            ]);

        } catch (\Throwable $e) {

            Log::error('Send OTP Error: ' . $e->getMessage());

            return response()->json([

                'status' => false,
                'message' => 'Failed to send OTP'

            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [

                'email' => 'required|email',
                'otp' => 'required|digits:6'

            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $email = strtolower(trim($request->email));

            $user = User::where('email', $email)->first();

            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            if (!$user->is_active) {

                return response()->json([
                    'status' => false,
                    'message' => 'Your account is inactive'
                ], 403);
            }

            if (
                $user->otp != $request->otp ||
                now()->greaterThan($user->otp_expires_at)
            ) {

                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired OTP'
                ], 401);
            }

            // clear old tokens
            $user->tokens()->delete();

            // clear otp
            $user->update([
                'otp' => null,
                'otp_expires_at' => null,
            ]);

            // generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([

                'status' => true,
                'message' => 'OTP verified successfully',

                'data' => [

                    'token' => $token,

                    'user' => [

                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone_no' => $user->phone_no,
                        'user_role' => $user->user_role,
                        'profile_image' => $user->profile_image
                            ? url('admin-assets/img/users/' . $user->profile_image)
                            : null,
                    ]
                ]

            ]);

        } catch (\Throwable $e) {

            Log::error('Verify OTP Error: ' . $e->getMessage());

            return response()->json([

                'status' => false,
                'message' => 'Something went wrong'

            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            $user = $request->user();

            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated user'
                ], 401);
            }

            // Delete current token only
            $user->currentAccessToken()->delete();

            return response()->json([

                'status' => true,
                'message' => 'Logout successful'

            ], 200);

        } catch (\Throwable $e) {

            Log::error('Logout Error: ' . $e->getMessage());

            return response()->json([

                'status' => false,
                'message' => 'Failed to logout'

            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {

            $user = $request->user();

            if (!$user) {

                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated user'
                ], 401);
            }

            return response()->json([

                'status' => true,
                'message' => 'Profile fetched successfully',

                'data' => [

                    'user' => [

                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone_no' => $user->phone_no,
                        'user_role' => $user->user_role,

                        'profile_image' => $user->profile_image
                            ? url('admin-assets/img/users/' . $user->profile_image)
                            : null,

                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,

                        'is_active' => $user->is_active,
                        'is_available' => $user->is_available,

                        'created_at' => $user->created_at
                            ? $user->created_at->format('d M Y h:i A')
                            : null,
                    ]
                ]

            ], 200);

        } catch (\Throwable $e) {

            Log::error('Profile Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch profile'
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {

            $user = $request->user();

            if (!$user) {

                return response()->json([

                    'status' => false,
                    'message' => 'Unauthenticated user'

                ], 401);
            }

            $validator = Validator::make($request->all(), [

                'name' => 'nullable|string|max:255',

                'email' => 'nullable|email|unique:users,email,' . $user->id,

                'phone_no' => 'nullable|string|min:10|unique:users,phone_no,' . $user->id,

                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            ]);

            if ($validator->fails()) {

                return response()->json([

                    'status' => false,
                    'message' => $validator->errors()->first()

                ], 422);
            }

            // Update Name
            if ($request->filled('name')) {

                $user->name = $request->name;
            }

            // Update Email
            if ($request->filled('email')) {

                $user->email = strtolower(trim($request->email));
            }

            // Update Phone
            if ($request->filled('phone_no')) {

                $user->phone_no = $request->phone_no;
            }

            // Update Profile Image
            if ($request->hasFile('profile_image')) {

                $image = $request->file('profile_image');

                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('admin-assets/img/users'), $imageName);

                $user->profile_image = $imageName;
            }

            $user->save();

            return response()->json([

                'status' => true,

                'message' => 'Profile updated successfully',

                'data' => [

                    'id' => $user->id,

                    'name' => $user->name,

                    'email' => $user->email,

                    'phone_no' => $user->phone_no,

                    'user_role' => $user->user_role,

                    'profile_image' => $user->profile_image
                        ? url('admin-assets/img/users/' . $user->profile_image)
                        : null,
                ]

            ], 200);

        } catch (\Throwable $th) {

            Log::error('Update Profile Error: ' . $th->getMessage());

            return response()->json([

                'status' => false,
                'message' => 'Something went wrong while updating profile'

            ], 500);
        }
    }

    public function getUserRole(Request $request)
    {
        try {

            $user = $request->user();

            if (!$user) {

                return response()->json([

                    'status' => false,
                    'message' => 'Unauthenticated user'

                ], 401);
            }

            return response()->json([

                'status' => true,

                'data' => [

                    'user_role' => $user->user_role

                ]

            ], 200);

        } catch (\Throwable $th) {

            Log::error('Get User Role Error: ' . $th->getMessage());

            return response()->json([

                'status' => false,
                'message' => 'Something went wrong'

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

    public function triggerSignal(Request $request)
    {
        // Validate that lat/long are in the request BODY
        $validator = Validator::make($request->all(), [
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();

            return DB::transaction(function () use ($request, $user) {
                // 1. Store the signal in emergency_signals
                $signal = EmergencySignal::create([
                    'user_id'       => $user->id,
                    'signal_id'     => 'SIG-' . strtoupper(uniqid()),
                    'signal_status' => 'Active',
                    'latitude'      => $request->latitude,
                    'longitude'     => $request->longitude,
                ]);

                // 2. Find responders within 1km (Haversine Formula)
                $radius = 1;
                $nearbyResponders = User::select('id', 'user_role')
                    ->whereIn('user_role', ['Police', 'Gym_Person', 'Defense'])
                    ->where('id', '!=', $user->id)
                    ->selectRaw(
                        "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
                        [$request->latitude, $request->longitude, $request->latitude]
                    )
                    ->having('distance', '<=', $radius)
                    ->get();

                // 3. Create the Emergency Group
                $group = EmergencyGroup::create([
                    'signal_id'  => $signal->id,
                    'group_name' => "Rescue Group for " . $user->name,
                ]);

                // 4. Add nearby members to emergency_group_members
                if ($nearbyResponders->isNotEmpty()) {
                    $membersData = $nearbyResponders->map(function ($responder) use ($group) {
                        return [
                            'group_id'   => $group->id,
                            'user_id'    => $responder->id,
                            'joined_at'  => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    })->toArray();

                    EmergencyGroupMember::insert($membersData);
                }

                return response()->json([
                    'status'  => true,
                    'message' => 'Signal activated. ' . $nearbyResponders->count() . ' helpers notified.',
                    'data'    => [
                        'signal_id' => $signal->signal_id,
                        'group_id'  => $group->id,
                        'helpers_found' => $nearbyResponders->count()
                    ]
                ]);
            });
        } catch (\Throwable $th) {
            Log::error('Signal Error: ' . $th->getMessage());
            return response()->json(['status' => false, 'message' => 'Server Error'], 500);
        }
    }
    /**
     * Updates the user's current GPS coordinates.
     * Used by Flutter in the background to keep the responder's position fresh.
     */
    public function updateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();

            $user->update([
                'latitude'             => $request->latitude,
                'longitude'            => $request->longitude,
                'last_location_update' => now(),
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Location updated.',
                'data'    => [
                    'lat' => $user->latitude,
                    'lng' => $user->longitude,
                    'last_sync' => $user->last_location_update->toDateTimeString()
                ]
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Location Update Error: " . $th->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Server error during location sync.'
            ], 500);
        }
    }
    /**
     * Records a helper's response to an active signal.
     * This populates the 'emergency_responses' table.
     */
    public function respondToSignal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signal_id' => 'required|exists:emergency_signals,id',
            'action'    => 'required|string',
            'notes'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $user = $request->user();

            $responderType = 'helper';
            if (in_array($user->user_role, ['Police', 'Defense'])) {
                $responderType = 'police';
            }

            $response = EmergencyResponse::create([
                'signal_id'       => $request->signal_id,
                'responder_type'  => $responderType,
                'user_id'         => $user->id,
                'response_action' => $request->action,
                'response_notes'  => $request->notes ?? 'Responder is moving to location.',
                'status'          => 'in_progress',
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Response registered. You are now linked to this emergency.',
                'data'    => $response
            ]);
        } catch (\Throwable $th) {
            Log::error("Response Error: " . $th->getMessage());
            return response()->json(['status' => false, 'message' => 'Could not register response.'], 500);
        }
    }

    public function createCommunity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'community_name' => 'required|string|max:255|unique:community,community_name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user = $request->user();

            $community = Community::create([
                'community_name' => $request->community_name,
                'creater_id'     => $user->id,
            ]);

            $user->update([
                'community_id' => $community->id
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Community created and user assigned successfully',
                'data' => [
                    'community' => $community,
                    'user_community_id' => $user->community_id
                ]
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack(); // Undo changes if something fails
            Log::error('Error creating community: ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'An error occurred. Please try again later.'
            ], 500);
        }
    }

    // public function addContactsToCommunity(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'name'      => 'required|string|max:255',
    //             'phone_no'  => ['required', 'string', 'min:10', 'unique:users,phone_no'],
    //             'community_id'  => 'required|exists:community,id',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => $validator->errors()->first()
    //             ], 422);
    //         }

    //         $validated = $validator->validated();

    //         $contact = User::create([
    //             'name'      => $validated['name'],
    //             'phone_no'  => $validated['phone_no'],
    //             'password'  => Hash::make('defaultpassword'),
    //             'user_role' => 'User',
    //             'community_id' => $validated['community_id'],
    //         ]);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Contact added successfully',
    //             'data' => [
    //                 'id'        => $contact->id,
    //                 'name'      => $contact->name,
    //                 'phone_no'  => $contact->phone_no,
    //                 'community_id' => $contact->community_id,
    //             ]
    //         ], 201);
    //     } catch (\Throwable $th) {
    //         dd($th);
    //         Log::error('Error adding contact: ' . $th->getMessage());

    //         return response()->json([
    //             'status' => false,
    //             'message' => 'An error occurred while adding contact. Please try again later.'
    //         ], 500);
    //     }
    // }

    public function addContactsToCommunity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'community_id' => 'required|exists:community,id',
            'contacts'     => 'required|array|min:1',
            'contacts.*.name'     => 'required|string|max:255',
            'contacts.*.phone_no' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            $addedCount = 0;
            $communityId = $request->community_id;

            foreach ($request->contacts as $contactData) {
                User::updateOrCreate(
                    ['phone_no' => $contactData['phone_no']],
                    [
                        'name'         => $contactData['name'],
                        'community_id' => $communityId,
                        'user_role'    => 'User',
                        'password'     => Hash::make('defaultpassword'),
                    ]
                );
                $addedCount++;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "$addedCount contacts processed successfully.",
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Bulk Contact Error: ' . $th->getMessage());
            return response()->json(['status' => false, 'message' => 'Error processing contacts.'], 500);
        }
    }
}
