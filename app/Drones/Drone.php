<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 07-Feb-17
 * Time: 21:01
 */

namespace App\Drones;


use App\Services\GeoLocation\SimpleCalculator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property float start_long
 * @property float start_lat
 * @property float finish_long
 * @property float finish_lat
 * @property \Carbon\Carbon start_time
 * @property \Carbon\Carbon end_time
 **/
class Drone extends Model implements DroneContract
{
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $dates = [
        'start_time',
        'end_time'
    ];
    protected $casts = [
        'start_long' => 'float',
        'start_lat' => 'float',
        'finish_long' => 'float',
        'finish_lat' => 'float',
    ];
    /**
     * @var SimpleCalculator
     */
    private $calculator;

    public function __construct()
    {
        parent::__construct();
        $this->calculator = app(SimpleCalculator::class);
    }


    /**
     * @return Type|BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    public function remainingFuel(): float
    {
        $spentFuel = $this->traveledDistance() / $this->type()->milesPerUnit;
        return $this->type()->fuelUnits - $spentFuel;
    }

    public function remainingFuelPercent(): int
    {
        $remaining = ($this->type()->fuelUnits * $this->remainingFuel()) / 100;
        return floor($remaining);
    }

    public function traveledDistance(): float
    {
        return $this->type()->speed * $this->duration();
    }

    public function progressPercent(): int
    {
        $tripDistance = $this->routeDistance();
        $progress = ($tripDistance * 100) / $this->traveledDistance();
        return floor($progress);
    }

    public function duration(): float
    {
        $now = new Carbon('now', $this->start_time->tz);
        return $now->diffInMinutes($this->end_time) / 60;
    }

    public function routeDistance(): int
    {
        return (int)$this->calculator->distanceTo($this->start_lat, $this->start_long, $this->finish_lat, $this->finish_long);
    }

    public function remainingDistance(): int
    {
        $remaining = $this->routeDistance() - ($this->getType()->speed * $this->duration());
        return $remaining;
    }

    public function setEndTime(string $tz = null)
    {
        $tz = $tz ?? env('APP_TIMEZONE');
        $tripDuration = ($this->routeDistance() / $this->getType()->speed) * 60;
        $time = new Carbon('now', $tz);
        $time->addMinutes(floor($tripDuration));
        $this->end_time = $time;
    }

}