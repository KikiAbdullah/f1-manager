<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamDriver extends Model
{
    protected $fillable = [
        'team_id',
        'driver_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
