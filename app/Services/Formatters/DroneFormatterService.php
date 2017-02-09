<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 08-Feb-17
 * Time: 08:13
 */

namespace App\Services\Formatters;


use App\Drones\Drone;
use App\Services\GeoLocation\SimpleCalculator;
use Carbon\Carbon;

class DroneFormatterService
{
    /**
     * @var Drone $drone
     **/
    protected $drone;

    /**
     * @param Drone $drone
     * @return string
     */
    public function getDroneListCommandFormat(Drone $drone): string
    {
        $this->setDrone($drone);
        $view = <<<VIEW
| {$this->getDroneName()} | {$this->getDepartureLocation()} | {$this->getDepatureTime()} | {$this->getTripDistance()} | {$this->getTripDuration()} | {$this->getArrivalLocation()} | {$this->getArrivalTime()} | {$this->getTripProgress()} | {$this->getRemainingFuel()} |
----------------------------------------------------------------------------------------------------

VIEW;
        return $view;
    }

    /**
     * @param Drone $drone
     * @return string
     */
    public function getDroneMissionCommandFormat(Drone $drone): string
    {
        $this->setDrone($drone);
        $view = <<<VIEW
| {$this->getDepatureTime()} | {$this->getTripDistance()} | {$this->getTripDuration()} | {$this->getArrivalTime()} |
-----------------------------------------------------------------------------------------------------

VIEW;
        return $view;
    }

    /**
     * @return string
     */
    private function getDroneName(): string
    {
        return $this->getDrone()->getName();
    }

    /**
     * @return Drone
     */
    public function getDrone(): Drone
    {
        return $this->drone;
    }

    /**
     * @param Drone $drone
     */
    public function setDrone(Drone $drone)
    {
        $this->drone = $drone;
    }

    /**
     * @return string
     */
    private function getDepartureLocation(): string
    {
        return $this->getDrone()->start_lat . " , " . $this->getDrone()->start_long;
    }

    private function getDepatureTime()
    {
        return "  ".$this->getDrone()->start_time->hour . ' : ' . $this->getDrone()->start_time->minute . " " . $this->getDrone()->start_time->timezoneName . "  ";
    }

    private function getTripDistance(): string
    {
        return $this->getDrone()->routeDistance() . ' miles  ';
    }

    private function getTripDuration(): string
    {
        return (string)number_format($this->getDrone()->duration(),1)."  ";
    }

    private function getArrivalLocation(): string
    {
        return $this->getDrone()->finish_lat . ' , ' . $this->getDrone()->finish_long;
    }

    private function getArrivalTime(): string
    {
        return $this->getDrone()->end_time->hour . ' : ' . $this->getDrone()->end_time->minute . " " . $this->getDrone()->end_time->timezoneName;
    }

    private function getTripProgress(): string
    {
        return $this->getDrone()->progressPercent() . "%";
    }

    private function getRemainingFuel(): string
    {
        return $this->getDrone()->remainingFuelPercent() . "%";
    }


}