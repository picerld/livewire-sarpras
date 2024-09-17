<?php

namespace App\Providers;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
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
        $submissionsNotify = Submission::where('status', 'pending')->orderBy('created_at', 'DESC')->paginate(3);

        View::share('submissions', $submissionsNotify);
    }
}
