<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name',
        'team_id',
        'engine_id',
        'tech_director_id',
        'aero_chief_id',
        'race_engineer_id',
        'top_speed', //Engine.Power + (Aero.Efficiency / 2) – (Aero.Downforce / 3)
        'cornering', //Aero.Downforce + (Tech.Engineering / 2) – (Engine.Power / 3)
        'reliability', //Engine.Reliability + (Tech.Engineering / 2) – (Innovation Risk)
        'fuel_efficiency', //Engine.FuelEfficiency + (Aero.Efficiency / 2)
        'tyre_management', //RaceEngineer.Strategy + Driver.Experience/2
        'cooling', //Engine.HeatManagement + Tech.Engineering/2
        'acceleration',
        'braking',
        'aero_efficiency',
        'adaptability',
        'pit_stop_speed',
        'overall_score',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }


    public function techDirector()
    {
        return $this->belongsTo(TechDirector::class);
    }

    public function aeroChief()
    {
        return $this->belongsTo(AeroChief::class);
    }

    public function raceEngineer()
    {
        return $this->belongsTo(RaceEngineer::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'car_drivers')
            ->withPivot('season_year')
            ->withTimestamps();
    }
}
