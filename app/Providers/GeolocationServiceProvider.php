<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 22:28
 */

namespace App\Providers;


use App\Services\GeoLocation\SimpleCalculator;
use Illuminate\Support\ServiceProvider;

class GeolocationServiceProvider extends ServiceProvider
{
    const KEY = 'geo_distance_calculator';

    public function register()
    {
        $this->app->singleton(self::KEY, function ($app) {
            return new SimpleCalculator();
        });
    }
}