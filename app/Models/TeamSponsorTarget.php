<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamSponsorTarget extends Model
{
    protected $fillable = ['team_sponsor_id', 'description', 'difficulty', 'due_date', 'status'];

    public function teamSponsor()
    {
        return $this->belongsTo(TeamSponsor::class);
    }
}
