<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamFinance extends Model
{
    protected $fillable = [
        'team_id',
        'description',
        'amount',
        'type',
        'category',
        'transaction_date'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
