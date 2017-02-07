<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 21:01
 */

namespace App\Drones;


use Illuminate\Database\Eloquent\Model;
/**
 * @property string start_long
 * @property string start_lat
 * @property string finish_long
 * @property string finish_lat
 * @property \DateTime start_time
 * @property \DateTime end_time
**/
class Drone extends Model implements DroneContract
{
    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function maxRange(): float
    {
        // TODO: Implement maxRange() method.
    }

    public function remainingFuel(): float
    {
        // TODO: Implement remainingFuel() method.
    }

    public function progress(): int
    {
        // TODO: Implement progress() method.
    }

    public function duration(): \DateTime
    {
        // TODO: Implement duration() method.
    }

    public function routeDistance(): int
    {
        // TODO: Implement routeDistance() method.
    }

    public function remainingDistance(): int
    {
        // TODO: Implement remainingDistance() method.
    }
}