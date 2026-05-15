<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     */
    public function boot() {
        // AND (ALL required)
        Blade::if('can', function (...$permissions) {
            return Role::hasPermission($permissions, 'AND');
        });

        // ANY (OR)
        Blade::if('canAny', function (...$permissions) {
            return Role::hasPermission($permissions, 'ANY');
        });

        // ALL (same as can(), but separate name)
        Blade::if('canAll', function (...$permissions) {
            return Role::hasPermission($permissions, 'AND');
        });
    }

    /**
     * Register the application services.
     */
    public function register() {
        //
    }
}
