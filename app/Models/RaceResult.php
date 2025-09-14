<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceResult extends Model
{
    protected $fillable = [
        'schedule_id',
        'driver_id',
        'lap_number',
        'sector1_time',
        'sector2_time',
        'sector3_time',
        'lap_time',
        'dnf',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
