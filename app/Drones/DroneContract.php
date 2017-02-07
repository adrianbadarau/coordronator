<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 21:07
 */

namespace App\Drones;


interface DroneContract
{
    public function maxRange(): float;

    public function remainingFuel(): float;

    public function progress(): int;

    public function duration(): \DateTime;

    public function routeDistance(): int;

    public function remainingDistance(): int;
}