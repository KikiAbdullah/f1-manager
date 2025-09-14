<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'funding_amount',
        'target_difficulty',
        'target_description',
        'penalty_amount',
        'created_by'
    ];

    public function teams()
    {
        return $this->hasMany(TeamSponsor::class);
    }
}
