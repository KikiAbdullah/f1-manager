<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'race_date',
        'circuit_id',
        'season',
        'weather_forecast',
        'actual_weather',
        'air_temp',
        'track_temp',
        'laps',
        'safety_car_probability',
        'average_pit_time',
        'status',
    ];

    /**
     * Get the circuit associated with the schedule.
     */
    public function circuit()
    {
        return $this->belongsTo(Circuit::class);
    }

    /**
     * Get the race results for the schedule.
     */
    public function raceResults()
    {
        return $this->hasMany(RaceResult::class);
    }

    /**
     * Get the qualifying results for the schedule.
     */
    public function qualifyingResults()
    {
        return $this->hasMany(QualifyingResult::class);
    }

    public function getWeatherFormattedAttribute()
    {
        $icon = '';
        $color = '';
        $label = '';

        switch ($this->weather_forecast) {
            case 'sunny':
                $icon = '<i class="ri-sun-line ri-24px me-2 text-warning"></i>';
                $label = 'Sunny';
                break;
            case 'cloudy':
                $icon = '<i class="ri-cloud-line ri-24px me-2 text-secondary"></i>';
                $label = 'Cloudy';
                break;
            case 'rainy':
                $icon = '<i class="ri-showers-line ri-24px me-2 text-info"></i>';
                $label = 'Rainy';
                break;
            case 'overcast':
                $icon = '<i class="ri-cloudy-line ri-24px me-2 text-secondary"></i>';
                $label = 'Overcast';
                break;
            case 'stormy':
                $icon = '<i class="ri-thunderstorms-line ri-24px me-2 text-danger"></i>';
                $label = 'Stormy';
                break;
            default:
                $icon = '<i class="ri-question-line ri-24px me-2 text-light"></i>';
                $label = 'Unknown';
                break;
        }



        $html =  '<div class="d-flex align-items-center mb-2">';
        $html .=  $icon;
        $html .=  '<p class="mb-0">Forecast : <span class="fw-semibold">' . $label . '</span></p>';
        $html .= '</div>';

        return $html;
    }
}
