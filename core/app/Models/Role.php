<?php

namespace App\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Role extends Model {

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Main permission checker
     * $codes = permission(s)
     * $mode = 'AND' or 'ANY'
     */
    public static function hasPermission($codes = null, $mode = 'AND') {
        $admin = Auth::guard('admin')->user();

        // Super admin (always allow)
        if ($admin && $admin->id == 1) {
            return true;
        }

        // Determine route name if nothing passed
        if (!$codes) {
            $codes = [request()->route()->getName()];
        }

        // Always convert to array
        if (!is_array($codes)) {
            $codes = [$codes];
        }

        $codes = array_map(function($c) {
            return is_array($c) ? $c[0] : $c;
        }, $codes);

        $alwaysAllow = [
            'admin.profile*',
            'admin.password*',
        ];
        foreach ($codes as $code) {
            foreach ($alwaysAllow as $allow) {
                if (str_contains($allow, '*')) {
                    $prefix = rtrim($allow, '*');
                    if (str_starts_with($code, $prefix)) {
                        return true;
                    }
                } elseif ($code === $allow) {
                    return true;
                }
            }
        }

        // Cache role permissions
        $roleName = $admin->role->name ?? '';
        $permissionCacheKey = "{$roleName}_permissions";

        $permissions = Cache::rememberForever($permissionCacheKey, function () use ($admin) {
            return $admin->role->permissions->pluck('code')->toArray();
        });


        // ---------- ANY MODE (OR CHECK) ----------
        if ($mode === 'ANY') {
            foreach ($codes as $code) {

                // Wildcard a.*
                if (str_contains($code, '*')) {
                    $prefix = rtrim($code, '*');
                    foreach ($permissions as $perm) {
                        if (str_starts_with($perm, $prefix)) {
                            return true;
                        }
                    }
                }

                if (in_array($code, $permissions)) {
                    return true;
                }
            }
            return false;
        }

        // ---------- AND MODE (ALL MUST MATCH) ----------
        foreach ($codes as $code) {

            if (str_contains($code, '*')) {
                $prefix = rtrim($code, '*');
                $found = false;

                foreach ($permissions as $perm) {
                    if (str_starts_with($perm, $prefix)) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    return false;
                }
                continue;
            }

            if (!in_array($code, $permissions)) {
                return false;
            }
        }

        return true;
    }


    // Helper for Blade: @canall()
    public static function hasAll($codes) {
        return self::hasPermission($codes, 'AND');
    }

    // Helper for Blade: @canany()
    public static function hasAny($codes) {
        return self::hasPermission($codes, 'ANY');
    }



    protected static function boot() {
        parent::boot();

        // Clear cache on role update
        static::saved(function ($role) {
            Cache::forget($role->name . '_permissions');
        });
    }
}
