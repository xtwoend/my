<?php

namespace App\Models;

use Carbon\Carbon;
use LogicException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gln', 'meta', 'scan_time', 'line'];
    protected $casts = ['meta' => 'array', 'scan_time' => 'datetime:Y-m-d H:i:s'];

    public function racks()
    {
        return $this->hasMany(Rack::class, 'location_id');
    }

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Add inventory to this location with a GTIN.
     *
     * @param  string  $value
     * @param  int  $amount
     * @return \App\Warehouse\Models\Inventory|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \App\Warehouse\Exceptions\InvalidGtinException
     */
    public function addInventory($value, $amount = 1)
    {
        if ($amount < 1) {
            return $this->newCollection();
        }

        $instances = $this->newCollection(array_map(function () use ($value) {
            // $rack = $this->activeRack();
            return $this->inventory()->create([
                'gtin' => $value,
                'rack_id' => null,
                'scan_time' => Carbon::now(),
                'line' => null
            ]);
        }, range(1, $amount)));

        return $amount === 1 ? $instances->first() : $instances;
    }

    /**
     * Move inventory to another location with a GTIN.
     *
     * @param  string  $value
     * @param  \App\Warehouse\Models\Location  $location
     * @return \App\Warehouse\Models\Inventory
     *
     * @throws \LogicException
     * @throws \App\Warehouse\Exceptions\InvalidGtinException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function move($value, self $location)
    {
        if (! $location->exists) {
            throw new LogicException('Location does not exist.');
        }

        if ($location->is($this)) {
            throw new LogicException("Inventory can not be be moved to it's own location.");
        }

        return tap($this->inventory()->whereGtin($value)->first(), function ($model) use ($value, $location) {
            if ($model === null) {
                throw (new ModelNotFoundException)->setModel(Inventory::class, [$value]);
            }

            $model->update([
                'location_id' => $location->id,
            ]);
        });
    }

    /**
     * Move multiple inventory models to another location.
     *
     * @param  array  $values
     * @param  \App\Warehouse\Models\Location  $location
     * @return array
     */
    public function moveMany(array $values, self $location): array
    {
        $models = collect();

        DB::transaction(function () use ($values, $location, $models) {
            collect($values)->each(function ($value) use ($location, $models) {
                $models->push($this->move($value, $location));
            });
        });

        return $models->all();
    }

    /**
     * Remove inventory from this location with a GTIN.
     *
     * @param  string  $value
     * @return bool
     *
     * @throws \App\Warehouse\Exceptions\InvalidGtinException
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function removeInventory($value)
    {
        if (! $model = $this->inventory()->whereGtin($value)->oldest()->first()) {
            throw (new ModelNotFoundException)->setModel(Inventory::class, [$value]);
        }

        return $model->delete();
    }

    public function removeAllInventory(): int
    {
        return $this->inventory()->delete();
    }

    public function activeRack()
    {
        return $this->racks()->first();
    }
}
