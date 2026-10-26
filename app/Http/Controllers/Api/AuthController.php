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


    // user register & login
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

    // page
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

    // contact polic, manager, .... etc.
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
                    'user_role' => 'required|string|in:Police,Manager,Gym_Person',
                    'name'      => 'required|string|max:255',
                    'email'     => [
                        'required',
                        'string',
                        'email:rfc,dns',
                        'max:255',
                        'unique:users,email'
                    ],
                    'password'  => 'required|string|min:8',
                    'phone_no'  => [
                        'required',
                        'string',
                        'min:10',
                        'unique:users,phone_no'
                    ],
                    'latitude'  => 'required|numeric',
                    'longitude' => 'required|numeric',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status'  => false,
                        'message' => $validator->errors()->first(),
                        'errors'  => $validator->errors()
                    ], 422);
                }

                $validated = $validator->validated();

                $contact = User::create([
                    'user_role' => $validated['user_role'],
                    'name'      => $validated['name'],
                    'email'     => strtolower($validated['email']),
                    'password'  => Hash::make($validated['password']),
                    'phone_no'  => $validated['phone_no'],
                    'latitude'  => $validated['latitude'],
                    'longitude' => $validated['longitude'],
                ]);

                return response()->json([
                    'status'  => true,
                    'message' => 'Contact added successfully',
                    'data'    => [
                        'id'        => $contact->id,
                        'user_role' => $contact->user_role,
                        'name'      => $contact->name,
                        'email'     => $contact->email,
                        'phone_no'  => $contact->phone_no,
                        'latitude'  => $contact->latitude,
                        'longitude' => $contact->longitude,
                    ]
                ], 201);

            } catch (\Throwable $th) {
                Log::error('Error adding contact: ' . $th->getMessage());

                return response()->json([
                    'status'  => false,
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
                    'latitude' => 'required|numeric',
                    'longitude' => 'required|numeric',
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
                    'latitude' => $validated['latitude'],
                    'longitude' => $validated['longitude'],
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
                        'latitude'  => $contact->latitude,
                        'longitude'  => $contact->longitude,
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

    // ALERT  
        public function triggerSignal(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'latitude'  => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation Error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            try {
                $user = $request->user();

                // ==========================================
                // ALLOW ONLY GENERAL USER TO TRIGGER SOS
                // ==========================================
                if (!in_array($user->user_role, ['General_User', 'User'])) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Only general users can trigger an emergency SOS.',
                        'user_role' => $user->user_role,
                    ], 403);
                }

                // ==========================================
                // CREATE EMERGENCY SIGNAL
                // ==========================================
                $result = DB::transaction(function () use ($request, $user) 
                {

                    // 1. Create emergency signal
                    $signal = EmergencySignal::create([
                        'user_id'       => $user->id,
                        'signal_id'     => 'SIG-' . strtoupper(uniqid()),
                        'signal_status' => 'Active',
                        'latitude'      => $request->latitude,
                        'longitude'     => $request->longitude,
                    ]);

                    // 2. Find responders within 1 km
                    $nearbyResponders = User::query()
                        ->select('users.id', 'users.user_role')
                        ->whereIn('users.user_role', [
                            'Police',
                            'Gym_Person',
                            'Defense',
                        ])
                        ->where('users.id', '!=', $user->id)
                        ->whereNotNull('users.latitude')
                        ->whereNotNull('users.longitude')
                        ->selectRaw(
                            '(6371 * ACOS(LEAST(1, GREATEST(-1,
                                COS(RADIANS(?))
                                * COS(RADIANS(users.latitude))
                                * COS(RADIANS(users.longitude) - RADIANS(?))
                                + SIN(RADIANS(?))
                                * SIN(RADIANS(users.latitude))
                            )))) AS distance',
                            [
                                $request->latitude,
                                $request->longitude,
                                $request->latitude,
                            ]
                        )
                        ->having('distance', '<=', 1)
                        ->get();

                    // 3. Create emergency group
                    $group = EmergencyGroup::create([
                        'signal_id'  => $signal->id,
                        'group_name' => 'Rescue Group for ' . $user->name,
                    ]);

                    $now = now();

                    // 4. Add SOS creator as group owner
                    $membersData = [
                        [
                            'group_id'   => $group->id,
                            'user_id'    => $user->id,
                            'role'       => 'owner',
                            'status'     => 'approved',
                            'joined_at'  => $now,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ],
                    ];

                    // 5. Add nearby responders as pending members
                    foreach ($nearbyResponders as $responder) {
                        $membersData[] = [
                            'group_id'   => $group->id,
                            'user_id'    => $responder->id,
                            'role'       => 'member',
                            'status'     => 'pending',
                            'joined_at'  => null,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                    }

                    EmergencyGroupMember::insert($membersData);

                    return [
                        'signal'   => $signal,
                        'group'    => $group,
                        'responders' => $nearbyResponders,
                    ];
                });

                return response()->json([
                    'status'  => true,
                    'message' => 'Emergency signal activated successfully.',
                    'data'    => [
                        // Public signal code used by the app
                        'signal_id' => $result['signal']->signal_id,

                        // Internal numeric database ID
                        'signal_record_id' => $result['signal']->id,

                        'group_id' => $result['group']->id,
                        'signal_status' => $result['signal']->signal_status,
                        'helpers_found' => $result['responders']->count(),
                        'responders' => $result['responders']
                            ->map(function ($responder) {
                                return [
                                    'user_id' => $responder->id,
                                    'user_role' => $responder->user_role,
                                    'distance_km' => round(
                                        (float) $responder->distance,
                                        3
                                    ),
                                ];
                            })
                            ->values(),
                    ],
                ], 201);

            } catch (\Throwable $th) {
                Log::error('Signal Error: ' . $th->getMessage());

                return response()->json([
                    'status'  => false,
                    'message' => 'Unable to activate emergency signal.',
                ], 500);
            }
        }
   
        public function nearbySignals(Request $request)
        {
            $user = $request->user();

            // Only responders can view nearby SOS alerts
            if (!in_array($user->user_role, ['Police', 'Gym_Person', 'Defense'])) {
                return response()->json([
                    'status' => false,
                    'message' => 'Only responders can view nearby emergency alerts.',
                ], 403);
            }

            // Responder must have a saved location
            if ($user->latitude === null || $user->longitude === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please update your location before checking nearby emergencies.',
                ], 422);
            }

            try {
                $memberships = EmergencyGroupMember::with([
                    'group.signal.user',
                ])
                    ->where('user_id', $user->id)
                    ->where('role', 'member')
                    ->whereIn('status', ['pending', 'approved'])
                    ->get();

                $alerts = $memberships
                    ->map(function ($membership) use ($user) {
                        $group = $membership->group;

                        if (!$group || !$group->signal) {
                            return null;
                        }

                        $signal = $group->signal;

                        // Only active emergencies
                        if ($signal->signal_status !== 'Active') {
                            return null;
                        }

                        if ($signal->latitude === null || $signal->longitude === null) {
                            return null;
                        }

                        // Calculate distance between responder and SOS location
                        $lat1 = deg2rad((float) $user->latitude);
                        $lon1 = deg2rad((float) $user->longitude);
                        $lat2 = deg2rad((float) $signal->latitude);
                        $lon2 = deg2rad((float) $signal->longitude);

                        $a = sin(($lat2 - $lat1) / 2) ** 2
                            + cos($lat1) * cos($lat2)
                            * sin(($lon2 - $lon1) / 2) ** 2;

                        $distance = 6371 * 2 * asin(
                            min(1, sqrt($a))
                        );

                        // Only show alerts within 1 km
                        if ($distance > 1) {
                            return null;
                        }

                        $person = $signal->user;

                        return [
                            'signal_id' => $signal->signal_id,
                            'signal_record_id' => $signal->id,
                            'group_id' => $group->id,
                            'signal_status' => $signal->signal_status,
                            'created_at' => $signal->created_at,
                            'distance_km' => round($distance, 3),

                            'emergency_location' => [
                                'latitude' => (float) $signal->latitude,
                                'longitude' => (float) $signal->longitude,
                            ],

                            'user' => $person ? [
                                'user_id' => $person->id,
                                'name' => $person->name,
                                'phone_no' => $person->phone_no,
                            ] : null,

                            'my_response_status' => $membership->status,
                        ];
                    })
                    ->filter()
                    ->values();

                return response()->json([
                    'status' => true,
                    'message' => $alerts->isEmpty()
                        ? 'No active nearby emergencies found.'
                        : 'Nearby emergencies fetched successfully.',
                    'data' => [
                        'total_alerts' => $alerts->count(),
                        'alerts' => $alerts,
                    ],
                ]);

            } catch (\Throwable $th) {
                Log::error('Nearby SOS Error: ' . $th->getMessage());

                return response()->json([
                    'status' => false,
                    'message' => 'Unable to fetch nearby emergencies.',
                ], 500);
            }
        }

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
      
        public function respondToSignal(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'signal_id' => 'required',
                'group_id'  => 'required|integer|exists:emergency_groups,id',
                'action'    => 'required|string|in:accept,decline,accepted,declined',
                'notes'     => 'nullable|string|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation Error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            try {
                $user = $request->user();

                $action = strtolower($request->action);

                // Support both action formats
                $action = match ($action) {
                    'accepted' => 'accept',
                    'declined' => 'decline',
                    default    => $action,
                };

                $result = DB::transaction(function () use (
                    $request,
                    $user,
                    $action
                ) {
                    // 1. Resolve public signal code or numeric record ID
                    $signalQuery = EmergencySignal::query();

                    if (is_numeric($request->signal_id)) {
                        $signalQuery->where(function ($query) use ($request) {
                            $query->where('signal_id', $request->signal_id)
                                ->orWhere('id', $request->signal_id);
                        });
                    } else {
                        $signalQuery->where('signal_id', $request->signal_id);
                    }

                    $signal = $signalQuery->first();

                    if (!$signal) {
                        return [
                            'error' => true,
                            'code' => 404,
                            'message' => 'Emergency signal not found.',
                        ];
                    }

                    // 2. Ensure the group belongs to this signal
                    $group = EmergencyGroup::where('id', $request->group_id)
                        ->where('signal_id', $signal->id)
                        ->first();

                    if (!$group) {
                        return [
                            'error' => true,
                            'code' => 422,
                            'message' => 'The selected group does not belong to this signal.',
                        ];
                    }

                    // 3. Only an assigned responder may respond
                    $member = EmergencyGroupMember::where('group_id', $group->id)
                        ->where('user_id', $user->id)
                        ->where('role', 'member')
                        ->lockForUpdate()
                        ->first();

                    if (!$member) {
                        return [
                            'error' => true,
                            'code' => 403,
                            'message' => 'You are not an assigned responder for this emergency.',
                        ];
                    }

                    if ($signal->signal_status !== 'Active') {
                        return [
                            'error' => true,
                            'code' => 422,
                            'message' => 'This emergency is no longer active.',
                        ];
                    }

                    if ($member->status !== 'pending') {
                        return [
                            'error' => true,
                            'code' => 409,
                            'message' => 'You have already responded to this emergency.',
                        ];
                    }

                    // 4. Determine responder type
                    $responderType = in_array(
                        $user->user_role,
                        ['Police', 'Defense']
                    ) ? 'police' : 'helper';

                    // 5. Store the response using valid database enum values
                    $response = EmergencyResponse::create([
                        'signal_id'       => $signal->id,
                        'responder_type'  => $responderType,
                        'user_id'         => $user->id,
                        'response_action' => $action,
                        'response_notes'  => $request->notes
                            ?? ($action === 'accept'
                                ? 'Responder accepted the emergency.'
                                : 'Responder declined the emergency.'),
                        'status' => $action === 'accept'
                            ? 'in_progress'
                            : 'completed',
                    ]);

                    // 6. Use the actual enum values from your database
                    $member->status = $action === 'accept'
                        ? 'approved'
                        : 'rejected';

                    $member->joined_at = $action === 'accept'
                        ? now()
                        : null;

                    $member->save();

                    return [
                        'error' => false,
                        'signal' => $signal,
                        'group' => $group,
                        'response' => $response,
                        'action' => $action,
                    ];
                });

                if ($result['error']) {
                    return response()->json([
                        'status'  => false,
                        'message' => $result['message'],
                    ], $result['code']);
                }

                return response()->json([
                    'status'  => true,
                    'message' => $result['action'] === 'accept'
                        ? 'Emergency accepted successfully.'
                        : 'Emergency declined successfully.',
                    'data' => [
                        'response_id' => $result['response']->id,
                        'signal_id' => $result['signal']->signal_id,
                        'group_id' => $result['group']->id,
                        'action' => $result['action'],
                        'response_status' => $result['response']->status,
                        'member_status' => $result['action'] === 'accept'
                            ? 'approved'
                            : 'rejected',
                    ],
                ]);

            } catch (\Throwable $th) {
                Log::error('Response Error: ' . $th->getMessage());

                return response()->json([
                    'status'  => false,
                    'message' => 'Could not register emergency response.',
                ], 500);
            }
        }
        
        public function updateResponseStatus(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'response_id' => 'required|integer|exists:emergency_responses,id',
                'action' => 'required|string|in:on_the_way,arrived,help_completed,unable_to_help',
                'notes' => 'nullable|string|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            try {
                $user = $request->user();

                // Only Police, Gym Person and Defense can update responder status.
                if (!in_array($user->user_role, ['Police', 'Gym_Person', 'Defense'])) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Only assigned responders can update emergency status.',
                    ], 403);
                }

                $result = DB::transaction(function () use ($request, $user) {
                    $response = EmergencyResponse::where('id', $request->response_id)
                        ->where('user_id', $user->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$response) {
                        return [
                            'error' => true,
                            'code' => 404,
                            'message' => 'Your emergency response was not found.',
                        ];
                    }

                    $signal = EmergencySignal::find($response->signal_id);

                    if (!$signal) {
                        return [
                            'error' => true,
                            'code' => 404,
                            'message' => 'Emergency signal not found.',
                        ];
                    }

                    // Do not allow updates after the SOS is resolved.
                    if ($signal->signal_status !== 'Active') {
                        return [
                            'error' => true,
                            'code' => 409,
                            'message' => 'This emergency is no longer active.',
                        ];
                    }

                    // Only an accepted, ongoing response can be updated.
                    if (
                        $response->status !== 'in_progress' ||
                        !in_array($response->response_action, [
                            'accept',
                            'on_the_way',
                            'arrived',
                        ])
                    ) {
                        return [
                            'error' => true,
                            'code' => 409,
                            'message' => 'This response cannot be updated further.',
                        ];
                    }

                    $action = $request->action;

                    $response->response_action = $action;

                    if ($request->filled('notes')) {
                        $response->response_notes = $request->notes;
                    } else {
                        $response->response_notes = match ($action) {
                            'on_the_way' => 'Responder is on the way.',
                            'arrived' => 'Responder has arrived at the location.',
                            'help_completed' => 'Emergency assistance completed.',
                            'unable_to_help' => 'Responder is unable to help.',
                        };
                    }

                    $response->status = in_array($action, [
                        'help_completed',
                        'unable_to_help',
                    ]) ? 'completed' : 'in_progress';

                    $response->save();

                    // Mark the SOS resolved only when help is completed.
                    if ($action === 'help_completed') {
                        $signal->signal_status = 'Resolved';
                        $signal->save();
                    }

                    return [
                        'error' => false,
                        'response' => $response,
                        'signal' => $signal,
                    ];
                });

                if ($result['error']) {
                    return response()->json([
                        'status' => false,
                        'message' => $result['message'],
                    ], $result['code']);
                }

                $response = $result['response'];

                return response()->json([
                    'status' => true,
                    'message' => 'Emergency status updated successfully.',
                    'data' => [
                        'response_id' => $response->id,
                        'signal_id' => $result['signal']->signal_id,
                        'responder_id' => $user->id,
                        'responder_name' => $user->name,
                        'responder_role' => $user->user_role,
                        'response_action' => $response->response_action,
                        'response_notes' => $response->response_notes,
                        'response_status' => $response->status,
                        'signal_status' => $result['signal']->signal_status,
                        'updated_at' => $response->updated_at,
                    ],
                ]);
            } catch (\Throwable $th) {
                Log::error('Response Status Update Error: ' . $th->getMessage());

                return response()->json([
                    'status' => false,
                    'message' => 'Unable to update emergency status.',
                ], 500);
            }
        }
        
        public function getSignalStatus(Request $request, string $signalId)
        {
            $user = $request->user();

            $signal = EmergencySignal::where('signal_id', $signalId)
                ->with(['responses.user:id,name,user_role'])
                ->first();

            if (!$signal) {
                return response()->json([
                    'status' => false,
                    'message' => 'Emergency signal not found.',
                ], 404);
            }

            // Only the person who created this SOS can view its tracking details.
            if ((int) $signal->user_id !== (int) $user->id) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not allowed to view this emergency.',
                ], 403);
            }

            return response()->json([
                'status' => true,
                'message' => 'Emergency status fetched successfully.',
                'data' => [
                    'signal_id' => $signal->signal_id,
                    'signal_status' => $signal->signal_status,
                    'created_at' => $signal->created_at,
                    'responders' => $signal->responses->map(function ($response) {
                        return [
                            'response_id' => $response->id,
                            'responder_id' => $response->user_id,
                            'responder_name' => $response->user?->name,
                            'responder_role' => $response->user?->user_role,
                            'response_action' => $response->response_action,
                            'response_notes' => $response->response_notes,
                            'response_status' => $response->status,
                            'updated_at' => $response->updated_at,
                        ];
                    })->values(),
                ],
            ]);
        }


    // Community
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
