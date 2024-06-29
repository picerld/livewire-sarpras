<?php

namespace App\Providers;

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
        // $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->role == 'admin';
        });

        Gate::define('isUnit', function ($user) {
            return $user->role == 'unit';
        });

        Gate::define('isPetugas', function ($user) {
            return $user->role == 'petugas';
        });

        Gate::define('isPengawas', function ($user) {
            return $user->role == 'pengawas';
        });
    }
}
