<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\Submission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // format idr currency
        Blade::directive('currency', function ($expression) {
            return "Rp {{ number_format($expression, 0, ',', '.') }}";
        });
    }
}
