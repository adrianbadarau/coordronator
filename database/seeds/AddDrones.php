<?php

use App\Drones\Drone;
use App\Services\GeoLocation\SimpleCalculator;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AddDrones extends Seeder
{
    private $coords = [
        [51.916742, 0.132552, 'UTC'],
        [50.849583, 4.331922, '+1'],
        [47.506446, 19.070771, '+1'],
        [48.675707, 44.523886, '+3']
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->coords as $coord){
            $this->addDrone($coord[0],$coord[1],$coord[2]);
        }
    }

    private function addDrone($lat, $long, $timezone)
    {
        $drone = new Drone(app(SimpleCalculator::class));
        $drone->type_id = 3;
        $drone->start_lat = config('config.homebase.lat');
        $drone->start_long = config('config.homebase.long');
        $drone->start_time = new Carbon('now',env('APP_TIMEZONE'));
        $drone->finish_lat = $lat;
        $drone->finish_long = $long;
        $drone->setEndTime($timezone);
        $drone->save();
    }
}
