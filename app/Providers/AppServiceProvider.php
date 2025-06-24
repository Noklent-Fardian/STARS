<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS when using Ngrok or production
        if (env('FORCE_HTTPS') || str_contains(request()->getHost(), 'ngrok')) {
            URL::forceScheme('https');
        }
    }
}