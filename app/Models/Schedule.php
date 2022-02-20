<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['shift_id', 'from', 'to', 'active'];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
