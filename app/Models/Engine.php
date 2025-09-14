<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $fillable = [
        'name',
        'power',
        'reliability',
        'heat_management',
        'fuel_efficiency',
        'drivability',
        'hybrid_system',
        'innovation',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
