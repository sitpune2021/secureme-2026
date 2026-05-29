<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{


    // SETTINGS PAGE
    public function settings()
    {
        $admin = DB::table('users')

            ->where(
                'id',
                session('admin_id')
            )

            ->where(
                'user_role',
                'admin'
            )

            ->first();

        return view(
            'admin.settings',
            compact('admin')
        );
    }

    // PROFILE UPDATE
    public function profileUpdate(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email',

            'phone_no' => 'nullable',

            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);

        $data = [

            'name' => $request->name,

            'email' => $request->email,

            'phone_no' => $request->phone_no,

            'updated_at' => now()

        ];

        // IMAGE UPLOAD

        if ($request->hasFile('profile_photo')) {

            $image = $request->file('profile_photo');

            $imageName =
                time() . '.' .
                $image->getClientOriginalExtension();

            $image->move(
                public_path('admin_profile'),
                $imageName
            );

            $data['profile_image'] = $imageName;
        }

        // UPDATE USER

        DB::table('users')

            ->where(
                'id',
                session('admin_id')
            )

            ->update($data);

        // UPDATE SESSION

        session([

            'admin_email' => $request->email

        ]);

        return redirect()

            ->back()

            ->with(
                'success',
                'Profile Updated Successfully'
            );
    }

    // CHANGE PASSWORD
    public function changePassword(Request $request)
    {
        $request->validate([

            'current_password' => 'required',

            'new_password' => 'required|min:6',

            'confirm_password' => 'required|same:new_password'

        ], [

            'current_password.required' => 'Current password is required',

            'new_password.required' => 'New password is required',

            'new_password.min' => 'New password must be at least 6 characters',

            'confirm_password.required' => 'Confirm password is required',

            'confirm_password.same' => 'Confirm password does not match'

        ]);

        // GET ADMIN

        $admin = DB::table('users')

            ->where(
                'id',
                session('admin_id')
            )

            ->where(
                'user_role',
                'admin'
            )

            ->first();

        // CHECK OLD PASSWORD

        if (!Hash::check($request->current_password, $admin->password)) {

            return redirect()

                ->back()

                ->with(
                    'error',
                    'Current password is incorrect'
                );
        }

        // UPDATE PASSWORD

        DB::table('users')

            ->where(
                'id',
                session('admin_id')
            )

            ->update([

                'password' => Hash::make($request->new_password),

                'updated_at' => now()

            ]);

        return redirect()

            ->back()

            ->with(
                'success',
                'Password Changed Successfully'
            );
    }

    
}