<?php
/**
 * User: JohnAVu
 * Date: 2019-12-18
 * Time: 14:14
 */

namespace App\Http\Middleware;

use Closure;


class RedirectIfNotCustomer
{
    public function handle($request, Closure $next, $guard = "parents")
    {
        if (!auth()->guard($guard)->check()) {
            return redirect(route('customer.login'));
        }
        return $next($request);
    }
}