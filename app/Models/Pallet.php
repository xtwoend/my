<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_report_id', 'barcode', 'number', 'qty', 'production_date'
    ];

    public function report()
    {
        return $this->belongsTo(InventoryReport::class, 'inventory_report_id');
    }
}
