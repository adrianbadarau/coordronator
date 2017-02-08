<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 08-Feb-17
 * Time: 07:48
 */

namespace App\Console\Commands;


use App\Drones\Drone;
use App\Services\Formatters\DroneFormatterService;
use Illuminate\Console\Command;

class ViewDrones extends Command
{
    protected $signature = 'drone:list';
    protected $description = 'Lists all drones';
    /**
     * @var Drone
     */
    private $droneRepo;
    /**
     * @var DroneFormatterService
     */
    private $droneFormatter;

    public function __construct(Drone $droneRepo, DroneFormatterService $droneFormatter)
    {
        parent::__construct();

        $this->droneRepo = $droneRepo;
        $this->droneFormatter = $droneFormatter;
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
            $table .= $this->droneFormatter->getDroneListCommandFormat($drone);
        }

    }

}