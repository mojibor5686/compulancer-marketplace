<?php

namespace App\Http\Middleware;

use Closure;

class SetUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route()->named('user.seller*')) {
            session(['userType' => 'seller']);
        } elseif ($request->route()->named('user.buyer*')) {
            session(['userType' => 'buyer']);
        }

        return $next($request);
    }
}
