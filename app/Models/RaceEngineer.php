<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceEngineer extends Model
{
    protected $fillable = [
        'name',
        'strategy',
        'tyre_management',
        'communication',
        'adaptability',
        'fuel_management',
        'data_analysis',
        'salary'
    ];

    public function teams()
    {
        return $this->hasMany(TeamStaff::class);
    }
}
