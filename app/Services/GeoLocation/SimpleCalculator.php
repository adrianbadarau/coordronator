<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 22:38
 */

namespace App\Services\GeoLocation;


class SimpleCalculator implements DistanceCalculatorContract
{

    public function distanceTo(float $startLat, float $startLon, float $endLat, float $endLon)
    {
        $theta = $startLon - $endLon;
        $dist = sin(deg2rad($startLat)) * sin(deg2rad($endLat)) +  cos(deg2rad($startLat)) * cos(deg2rad($endLat)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $units = $dist * 60 * 1.1515;

        return $units * 1.609344;
    }
}