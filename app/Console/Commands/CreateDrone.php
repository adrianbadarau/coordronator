<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 22:51
 */

namespace App\Console\Commands;


use App\Drones\Drone;
use Illuminate\Console\Command;

class CreateDrone extends  Command
{
    protected $signature = 'drone:create {type_id}';
    protected $description = 'Create a new drone to add to the fleet';
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
        $this->droneRepo->fill([
            'type_id' => $this->argument('type_id')
        ])->save();
    }
}