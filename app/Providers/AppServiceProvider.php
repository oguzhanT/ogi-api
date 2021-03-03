<?php

namespace App\Providers;

use App\Http\Services\AppleService;
use App\Http\Services\GoogleService;
use App\Http\Services\ProviderInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProviderInterface::class, AppleService::class);
        $this->app->bind(ProviderInterface::class, GoogleService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
