<?php

namespace App\Models;

use LogicException;
use App\Models\Shift;
use App\Models\Location;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use BroadcastsEvents, HasFactory;

    protected $fillable = ['location_id', 'rack_id', 'gtin', 'line', 'scan_time', 'schedule_id'];

    protected $casts = ['scan_time' => 'datetime:Y-m-d H:i:s'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class, 'rack_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'gtin', 'gtin');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @param  string  $event
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn($event)
    {
        return [$this, $this->product, $this->schedule];
    }

    /**
     * @throws \LogicException
     */
    public function move(Location $location): bool
    {
        if (! $location->exists) {
            throw new LogicException('Location does not exist.');
        }

        if ($this->location_id === $location->id) {
            throw new LogicException("Inventory can not be be moved to it's own location.");
        }

        return $this->update([
            'location_id' => $location->id,
        ]);
    }
}
