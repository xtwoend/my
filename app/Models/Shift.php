<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'day', 'from', 'to', 'date', 'repeat', 'active'];

    protected $casts = ['repeat' => 'boolean', 'day' => 'array'];
}
