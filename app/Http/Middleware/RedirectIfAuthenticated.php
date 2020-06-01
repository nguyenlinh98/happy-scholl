<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param null|string $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == 'parents' && Auth::guard($guard)->check()) {
            return redirect()->route('front.mypage.index');
        }
        if ($guard == 'teacher' && Auth::guard($guard)->check()) {
            return redirect()->route('emergency.top');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/admin/home');
        }

        return $next($request);
    }
}
