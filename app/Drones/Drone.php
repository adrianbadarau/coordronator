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
 * @property int start_timezone
 * @property string end_timezone
 * @property string start_timezone
 **/
class Drone extends Model implements DroneContract
{
    protected $guarded = ['id'];
    public $timestamps = false;

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
        $spentFuel = $this->traveledDistance() / $this->getType()->milesPerUnit;
        return $this->getType()->fuelUnits - $spentFuel;
    }

    public function remainingFuelPercent(): int
    {

        $remaining = ($this->remainingFuel() / $this->getType()->fuelUnits) * 100;
        return floor($remaining);
    }

    public function traveledDistance(): float
    {
        $distance = $this->getType()->speed * $this->elapsedTime();
        return $distance >= $this->routeDistance() ? $this->routeDistance() : $distance;
    }

    public function progressPercent(): int
    {
        $progress = 100 - ($this->traveledDistance() / $this->routeDistance()) * 100;
        return floor($progress);
    }

    public function duration(): float
    {
        $now = new Carbon('now', $this->end_time->tz);
        return $now->diffInMinutes($this->end_time) / 60;
    }

    public function elapsedTime(): float
    {
        $now = new Carbon('now', $this->start_time->tz);
        return $this->start_time->diffInMinutes($now) / 60;
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

    public function setEndTime(string $tz = null): void
    {
        $tz = $tz ?? env('APP_TIMEZONE');
        $tripDuration = ($this->routeDistance() / $this->getType()->speed) * 60;
        $timezone = new \DateTimeZone($tz);
        $time = new Carbon('now', $timezone);
        $time->addMinutes(floor($tripDuration));
        $this->end_time = $time;
        $this->end_timezone = $tz;
    }

    public function setStartTime(string $tz = null): void
    {
        $tz = $tz ?? env('APP_TIMEZONE');
        $timezone = new \DateTimeZone($tz);
        $time = new Carbon('now', $timezone);
        $this->start_time = $time;
        $this->start_timezone = $tz;
    }

    public function getEndTimeAttribute($value): Carbon
    {
        $timezone = new \DateTimeZone($this->end_timezone);
        $date = new Carbon($value, $timezone);
        return $date;
    }

    public function getStartTimeAttribute($value): Carbon
    {
        $timezone = new \DateTimeZone($this->start_timezone);
        $date = new Carbon($value, $timezone);
        return $date;
    }

    public function getName(): string
    {
        return $this->getType()->name . '-' . $this->id;
    }

}