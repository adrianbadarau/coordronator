<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 08-Feb-17
 * Time: 07:48
 */

namespace App\Console\Commands;


use App\Drones\Drone;
use Illuminate\Console\Command;

class ViewDrones extends Command
{
    protected $signature = 'drone:list';
    protected $description = 'Lists all drones';
    /**
     * @var Drone
     */
    private $droneRepo;

    public function __construct(Drone $droneRepo)
    {
        parent::__construct();

        $this->droneRepo = $droneRepo;
    }


    public function handle()
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
            $table .= <<<DRONE
| {$drone->getDroneName()} | {$drone->getDepartureLocation()} | {$drone->getDepatureTime()} | {$drone->getTripDistance()} | {$drone->getTripDuration()} | {$drone->getArrivalLocation()} | {$drone->getArrivalTime()} | {$drone->getTripProgress()} | {$drone->getRemainingFuel()} |
----------------------------------------------------------------------------------------------------
DRONE;

        }

    }
}