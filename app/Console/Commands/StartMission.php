<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 09-Feb-17
 * Time: 07:19
 */

namespace App\Console\Commands;


use App\Drones\Drone;
use App\Drones\Type;
use App\Services\Formatters\DroneFormatterService;
use App\Services\GeoLocation\SimpleCalculator;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StartMission extends Command
{
    protected $signature = 'drone:mission:start';
    protected $description = 'Starts a drone mission';

    private $timeZoneHints = ['UTC', '+1', '+2', '+3', '-1', '-2', '-3'];
    /**
     * @var SimpleCalculator
     */
    private $calculator;
    /**
     * @var Drone
     */
    private $droneRepo;
    /**
     * @var Type
     */
    private $typeRepo;
    /**
     * @var DroneFormatterService
     */
    private $droneFormatter;

    public function __construct(SimpleCalculator $calculator, Drone $droneRepo, Type $typeRepo, DroneFormatterService $droneFormatter)
    {
        parent::__construct();
        $this->calculator = $calculator;
        $this->droneRepo = $droneRepo;
        $this->typeRepo = $typeRepo;
        $this->droneFormatter = $droneFormatter;
    }


    public function handle()
    {
        $drone = $this->getDroneFromInput();
        $this->displayResult($drone);

    }

    private function updateDrone(Drone $drone, float $startLat, float $startLon, string $startTz, float $finishLat, float $finishLon, string $finishTz): Drone
    {
        $drone->start_lat = $startLat;
        $drone->start_long = $startLon;
        $drone->finish_lat = $finishLat;
        $drone->finish_long = $finishLon;
        $drone->setStartTime($startTz);
        $drone->setEndTime($finishTz);
        $drone->save();

        return $drone;
    }

    /**
     * @return Drone
     * @throws \Exception
     */
    public function getDroneFromInput(): Drone
    {
        $startLat = (float)$this->ask('Add starting Latitude', config('config.homebase.lat'));
        $startLon = (float)$this->ask('Add start Longitude', config('config.homebase.long'));
        $startTz = $this->anticipate('Start time zone: ', $this->timeZoneHints, env('APP_TIMEZONE'));
        $finishLat = (float)$this->ask('Add finish Latitude', 51.916742);
        $finishLon = (float)$this->ask('Add finish Longitude', 0.132552);
        $finishTz = $this->anticipate('Finish time zone: ', $this->timeZoneHints, '+3');
        $missionDistance = $this->calculator->distanceTo($startLat, $startLon, $finishLat, $finishLon);
        $types = $this->typeRepo->all();
        $types = $types->filter(function (Type $type) use ($missionDistance) {
            return $type->maxRange() >= $missionDistance;
        });
        if (!$types->count()) {
            throw new \Exception("we are sorry but the mission distance is to much for our little drone => go design a better type of drone");
        }
        $types = $types->transform(function (Type $type) {
            return $type->id;
        })->toArray();
        $drones = $this->droneRepo->with('type')->whereIn('type_id', $types)->get();
        $droneHints = clone $drones;
        $droneHints = $droneHints->transform(function (Drone $drone) {
            return $drone->getName();
        })->toArray();
        $selectedDrone = $this->anticipate('Please select a Drone:', $droneHints);
        $drone = $drones->pop(function (Drone $drone) use ($selectedDrone) {
            return $drone->getName() === $selectedDrone;
        });
        $drone = $this->updateDrone($drone, $startLat, $startLon, $startTz, $finishLat, $finishLon, $finishTz);
        return $drone;
    }

    private function displayResult(Drone $drone): void
    {
        $table = <<<TEXT
--------------------------------------------------------------
| Departure Time | Flight Distance | Duration | Arrival Time | 
--------------------------------------------------------------

TEXT;
        $table.= $this->droneFormatter->getDroneMissionCommandFormat($drone);

        echo $table;
    }
}