<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'location_id', 'description', 'capacity', 'used', 'last_used_at', 'active'];

    protected $dates = ['last_used_at'];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function active()
    {
        return self::first();
    }
}
