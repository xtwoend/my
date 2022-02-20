<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sync extends Model
{
    use HasFactory;

    const FAILED = 'FAILED';
    const SUCCESS = 'SUCCESS';
    
    protected $fillable = ['location_id', 'date', 'status', 'trying', 'response'];
}
