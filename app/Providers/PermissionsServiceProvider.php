<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function ($user, $ability) {
            Gate::define($ability, function () use ($ability, $user) {
                try {
                    if ($user->hasRole('super-admin')) {
                        return true;
                    } else {
                        return $user->hasPermissionTo($ability);
                    }
                } catch (\Throwable $th) {
                    return false;
                }
            });
        });
    }
}
