<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 22:51
 */

namespace App\Console\Commands;


use App\Drones\Drone;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateDrone extends  Command
{
    protected $signature = 'drone:create {type_id}';
    protected $description = 'Create a new drone to add to the fleet';
    /**
     * @var Drone
     */
    private $droneRepo;

    public function handle()
    {
        $drone = new Drone();
        $drone->type_id = 3;
        $drone->start_lat = config('config.homebase.lat');
        $drone->start_long = config('config.homebase.long');
        $drone->setStartTime(env('APP_TIMEZONE'));
        $drone->save();
    }
}