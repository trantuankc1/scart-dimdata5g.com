<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginUserAgency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check())
        {
            if (Auth::user())
            {
                return $next($request);
            }
            return redirect()->route('agency_users.login')->with('error', 'Permission denied');
        }
        return redirect()->route('agency_users.login')->with('error', 'Permission denied');
    }
}
