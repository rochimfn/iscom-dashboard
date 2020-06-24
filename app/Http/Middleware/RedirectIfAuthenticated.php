<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if(Auth::user()->user_role_id == 1) {
                return redirect('/dashboard/users');
            } elseif (Auth::user()->user_role_id == 2) {
                return redirect('/home/members');
            } elseif (Auth::user()->user_role_id == 3) {
                return redirect('/home/dosen/settings');
            }

            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
