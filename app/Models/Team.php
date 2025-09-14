<?php

namespace App\Models;

use App\Models\Traits\CreatedByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    use CreatedByTrait;
    protected $table     = 'teams';
    protected $fillable = [
        'name',
        'manager_name',
        'country',
        'color_primary',
        'color_secondary',
        'created_by'
    ];

    // Relasi
    public function drivers()
    {
        return $this->hasMany(TeamDriver::class);
    }

    public function teamStaff()
    {
        return $this->hasMany(TeamStaff::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function sponsors()
    {
        return $this->hasMany(TeamSponsor::class);
    }

    public function loans()
    {
        return $this->hasMany(TeamLoan::class);
    }

    public function finances()
    {
        return $this->hasMany(TeamFinance::class);
    }
}
