<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDriver extends Model
{
    protected $fillable = ['car_id', 'driver_id', 'season_year'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
