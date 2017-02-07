<?php

use App\Drones\Type;
use Illuminate\Database\Seeder;

class AddDroneTypes extends Seeder
{
    /**
     * @var Type
     */
    private $droneTypeRepo;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'Prototype',
            'speed' => 60,
            'fuelUnits' => 10,
            'milesPerUnit' => 10
        ]);
        Type::create([
            'name' => 'Normal',
            'speed' => 40,
            'fuelUnits' => 20,
            'milesPerUnit' => 5
        ]);
        Type::create([
            'name' => 'TransContinental',
            'speed' => 20,
            'fuelUnits' => 50,
            'milesPerUnit' => 30
        ]);
    }
}
