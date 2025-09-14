<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AeroChief extends Model
{
    protected $fillable = [
        'name',
        'front_aero',
        'rear_aero',
        'drag_efficiency',
        'wind_tunnel',
        'ground_effect',
        'aero_innovation',
        'salary'
    ];

    public function teams()
    {
        return $this->hasMany(TeamStaff::class);
    }
}
