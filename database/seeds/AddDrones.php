<?php

use App\Drones\Drone;
use App\Services\GeoLocation\SimpleCalculator;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AddDrones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drone = new Drone(app(SimpleCalculator::class));
        $drone->type_id = 1;
        $drone->start_lat = config('config.homebase.lat');
        $drone->start_long = config('config.homebase.long');
        $drone->start_time = new Carbon('now',env('APP_TIMEZONE'));
        $drone->finish_lat = 51.916742;
        $drone->finish_long = 0.132552;
        $drone->setEndTime();
        $drone->save();
//        Drone::create([
//            'type_id' => 2,
//            'start_lat' => config('config.homebase.lat'),
//            'start_long' => config('config.homebase.long'),
//            'start_time' => new Carbon('now',env('APP_TIMEZONE'))
//        ]);
//        Drone::create([
//            'type_id' => 3,
//            'start_lat' => config('config.homebase.lat'),
//            'start_long' => config('config.homebase.long'),
//            'start_time' => new Carbon('now',env('APP_TIMEZONE'))
//        ]);
    }
}
