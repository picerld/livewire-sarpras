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

        Gate::define('isPengawas', function ($user) {
            return $user->role == 'pengawas';
        });

        Gate::define('createTransaction', function ($user) {
            return $user->role == 'admin' || $user->role == 'pengawas';
        });

        Gate::define('acceptTransaction', function ($user) {
            return $user->role == 'pengawas';
        });

        Gate::define('updateTransaction', function ($user) {
            return $user->role == 'admin';
        });
    }
}
