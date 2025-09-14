<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamLoan extends Model
{
    protected $fillable = ['team_id', 'loan_id', 'active'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function payments()
    {
        return $this->hasMany(TeamLoanPayment::class);
    }
}
