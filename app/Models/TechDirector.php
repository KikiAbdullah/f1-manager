<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechDirector extends Model
{
    protected $fillable = [
        'name',
        'chassis',
        'powertrain',
        'durability',
        'suspension',
        'cooling',
        'innovation',
        'salary'
    ];

    public function teams()
    {
        return $this->hasMany(TeamStaff::class);
    }
}
