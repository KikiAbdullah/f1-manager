<?php

namespace App\Models;

use App\Models\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;
    use CreatedByTrait;
    protected $table     = 'drivers';
    protected $fillable = [
        'name',
        'image',
        'cornering',
        'braking',
        'reactions',
        'control',
        'smoothness',
        'adaptability',
        'overtaking',
        'defending',
        'accuracy',
        'salary_per_race',
        'created_by'
    ];

    public function teams()
    {
        return $this->hasMany(TeamDriver::class);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_drivers')
            ->withPivot('season_year')
            ->withTimestamps();
    }
}
