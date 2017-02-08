<?php

use App\Drones\Drone;
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
        Drone::create([
            'type_id' => 1,
            'start_lat' => config('config.homebase.lat'),
            'start_long' => config('config.homebase.long'),
            'start_time' => new Carbon('now',env('APP_TIMEZONE'))
        ]);
        Drone::create([
            'type_id' => 2,
            'start_lat' => config('config.homebase.lat'),
            'start_long' => config('config.homebase.long'),
            'start_time' => new Carbon('now',env('APP_TIMEZONE'))
        ]);
        Drone::create([
            'type_id' => 3,
            'start_lat' => config('config.homebase.lat'),
            'start_long' => config('config.homebase.long'),
            'start_time' => new Carbon('now',env('APP_TIMEZONE'))
        ]);
    }
}
