<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 22:34
 */

namespace App\Services\GeoLocation;


interface DistanceCalculatorContract
{
    public function distanceTo(float $startLat, float $startLon, float $endLat, float $endLon);
}