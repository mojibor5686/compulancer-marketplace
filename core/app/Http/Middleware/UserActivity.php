<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserActivity {
    public function handle( Request $request, Closure $next ) {
        if ( auth()->check() ) {
            $expiresAt = now()->addMinutes( 5 );
            Cache::put( 'user-online-' . auth()->id(), true, $expiresAt );
        }

        return $next( $request );
    }
}