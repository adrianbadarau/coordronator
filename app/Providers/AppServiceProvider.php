<?php

namespace App\Providers;

use App\Services\Formatters\DroneFormatterService;
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
        $this->app->singleton(DroneFormatterService::class, function ($app) {
            return new DroneFormatterService();
        });
    }
}
