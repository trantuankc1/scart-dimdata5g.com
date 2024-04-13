<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckLoginUserAgency
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
//        dd($request->session()->all());
        if (Auth::guard('agency_user')->check()) {
            return redirect()->route('agency_user.dashboard');
        }

        return redirect()->route('agency_users.login')->with('error', 'Permission denied');
    }
}
