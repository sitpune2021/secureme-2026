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
    public function AdminLogin()
    {
        return view('admin.login');
    }

    public function SaveLogin(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required|min:6',
            ]);

            $admin = DB::table('admins')->where('email', $request->email)->first();

            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];

            if (Auth::guard('admin')->attempt($credentials)) {

                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Welcome back, Admin!');
            }
            return back()->withErrors(['email' => 'Invalid credentials']);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'An error occurred during the login process.',
            ], 500);
        }
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
