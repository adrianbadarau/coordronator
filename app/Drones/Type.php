<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 21:16
 */

namespace App\Drones;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property float $speed
 * @property integer $fuelUnits
 * @property float $milesPerUnit
 **/
class Type extends Model
{
    protected $guarded = ['id'];
    protected $table = 'drone_types';

    public function types()
    {
        return $this->hasMany(Drone::class, 'type_id');
    }

    public function maxRange(): float
    {
        return $this->fuelUnits * $this->milesPerUnit;
    }
}