<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamSponsor extends Model
{
    protected $fillable = ['team_id', 'sponsor_id', 'active'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function targets()
    {
        return $this->hasMany(TeamSponsorTarget::class);
    }
}
