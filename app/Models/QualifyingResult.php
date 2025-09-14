<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualifyingResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qualifying_results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'driver_id',
        'position',
        'q1_time',
        'q2_time',
        'q3_time',
    ];

    /**
     * Get the schedule associated with the qualifying result.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    /**
     * Get the driver associated with the qualifying result.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
}
