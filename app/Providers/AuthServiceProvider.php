<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::before(function ($user) {
            if ($user->email === config('acl.email_administrator')) {
                return true;
            }
        });

        Permission::with('roles')->get()->each(function ($permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        });
    }
}
