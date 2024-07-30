<?php

namespace App\Providers;

use App\Services\Vercel\VercelApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(VercelApiClient::class, function () {
            return new VercelApiClient(
                uri: config('services.vercel.uri'),
                timeout: config('services.vercel.timeout'),
                retryTimes: config('services.vercel.retry_times'),
                retryMilliseconds: config('services.vercel.retry_milliseconds'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
