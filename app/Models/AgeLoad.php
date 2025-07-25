<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeLoad extends Model
{
    protected $fillable = [
        'min_age',
        'max_age',
        'load',
    ];
}
