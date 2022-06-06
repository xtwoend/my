<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;
    protected $table = 'product_returns';
    protected $fillable = ['inventory_report_id', 'qty', 'reason', 'by'];

    public function report()
    {
        return $this->belongsTo(InventoryReport::class, 'inventory_report_id');
    }
}
