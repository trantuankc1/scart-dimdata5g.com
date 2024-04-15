<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginAgency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('agency_user')) {
            $user = $request->session()->get('agency_user');
            if ($user) {
                return $next($request);
            }
        }
        return redirect()->route('agency_users.login')->with('error', 'Permission denied');
    }
}
