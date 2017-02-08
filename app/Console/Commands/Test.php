<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 08-Feb-17
 * Time: 22:02
 */

namespace App\Console\Commands;


use App\Drones\Drone;
use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'test';
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
        $drone = $this->droneRepo->find(1);
    }
}