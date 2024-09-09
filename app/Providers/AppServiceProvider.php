<?php

namespace App\Providers;

use App\Models\Submission;
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
        $submissions = Submission::where('status', 'pending')->get();

        View::share('submissions', $submissions);
    }
}
