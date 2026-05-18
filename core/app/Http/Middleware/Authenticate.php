<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {
    /**
    * Get the path the user should be redirected to when they are not authenticated.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return string|null
    */
    protected function redirectTo( $request ) {
        if ( ! $request->expectsJson() ) {
            return url( '/' );
        }
    }

    /**
    * Handle an unauthenticated user.
    * * এখানে আমরা ইউজার লগইন না থাকলে নোটিফিকেশন সেশন সেট করে দেব।
    */
    protected function unauthenticated( $request, array $guards ) {
        if ( ! $request->expectsJson() ) {
            $notify[] = [ 'error', 'Please login to access this page.' ];
            session()->flash( 'notify', $notify );
        }

        parent::unauthenticated( $request, $guards );
    }
}