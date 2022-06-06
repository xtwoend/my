<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryReport extends Model
{
    use HasFactory;

    protected $fillable = ['location_id', 'product_id', 'schedule_id', 'qty', 'return_qty', 'pallet_qty', 'total'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function pallets()
    {
        return $this->hasMany(Pallet::class, 'inventory_report_id');
    }

    public function returns()
    {
        return $this->hasMany(ProductReturn::class, 'inventory_report_id');
    }
}
