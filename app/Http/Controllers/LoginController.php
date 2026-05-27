<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{


    // Show Admin login page
    public function AdminLogin(Request $request)
    {
        return view('admin.login');
    }

    public function SaveLogin(Request $request)
    {
        $request->validate([

            'email'    => 'required|email',

            'password' => 'required|min:6',

        ]);

        $credentials = [

            'email' => $request->email,

            'password' => $request->password,

            'user_role' => 'admin'

        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard')

                ->with('success', 'Welcome back Admin!');

        }

        return back()->withErrors([

            'email' => 'Invalid admin credentials'

        ]);
    }

    public function Logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.admin-login')->with('success', 'Logged out successfully');
    }

    
}
