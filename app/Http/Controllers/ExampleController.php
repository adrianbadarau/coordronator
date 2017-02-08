<?php

namespace App\Http\Controllers;

use App\Drones\Drone;
use App\Services\Formatters\DroneFormatterService;
use App\Services\GeoLocation\SimpleCalculator;
use Carbon\Carbon;

class ExampleController extends Controller
{
    /**
     * @var Drone
     */
    private $droneRepo;
    /**
     * @var DroneFormatterService
     */
    private $droneFormatter;

    /**
     * Create a new controller instance.
     *
     * @param Drone $droneRepo
     * @param DroneFormatterService $droneFormatter
     */
    public function __construct(Drone $droneRepo, DroneFormatterService $droneFormatter)
    {
        //
        $this->droneRepo = $droneRepo;
        $this->droneFormatter = $droneFormatter;
    }

    public function viewDrones()
    {
        /** @var Drone[] $drones */
        $drones = $this->droneRepo->all();
        $table = <<<TEXT
---------------------------------------------------------------------------------------------------
| Drone | Departure | Departure | Distance | Duration | Arrival  | Arrival | Progress | Remaining |
|       |  Location |   Time    |          |          | Location |  Time   |          |   Fuel    |
---------------------------------------------------------------------------------------------------
TEXT;

        foreach ($drones as $drone){
            $table .= $this->droneFormatter->getDroneListCommandFormat($drone);
        }

        echo $table;
        return;
    }

    public function createDrone()
    {
        $drone = new Drone();
        $drone->type_id = 3;
        $drone->start_lat = config('config.homebase.lat');
        $drone->start_long = config('config.homebase.long');
        $drone->finish_lat = 47.506446;
        $drone->finish_long = 19.070771;
        $drone->setStartTime();
        $drone->setEndTime('+1');
        $drone->save();
    }

    public function viewDrone($id)
    {
        $drone = $this->droneRepo->find($id);
        return $this->droneFormatter->getDroneListCommandFormat($drone);
    }
    //
}
