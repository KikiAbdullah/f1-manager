<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    protected $fillable = [
        'name',
        'length_km',
        'laps',
        'straight_length',
        'corner_density',
        'tyre_wear_level',
        'brake_wear_level',
        'overtake_difficulty',
        'drs_zones',
        'avg_speed',
        'downforce_level',
        'grip_level',
    ];
}
