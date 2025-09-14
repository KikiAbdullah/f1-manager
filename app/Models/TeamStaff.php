<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamStaff extends Model
{
    protected $fillable = [
        'team_id',
        'tech_director_id',
        'aero_chief_id',
        'race_engineer_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
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
}
