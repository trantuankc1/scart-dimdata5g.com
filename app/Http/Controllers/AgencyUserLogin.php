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
            // Đăng nhập thành công, chuyển hướng đến trang mong muốn
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email hoặc mật khẩu không chính xác.');
    }
}
