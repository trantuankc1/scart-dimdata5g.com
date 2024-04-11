<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgencyUserLogin extends Controller
{
    public function formLogin()
    {
        return view('agency_login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('agency_user.dashboard');
        }

        return back()->with('error', 'Email hoặc mật khẩu không chính xác.');
    }


    public function logoutAgencyUser(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('agency_users.login');
    }
}
