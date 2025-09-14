<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamLoanPayment extends Model
{
    protected $fillable = ['team_loan_id', 'amount', 'due_date', 'status'];

    public function teamLoan()
    {
        return $this->belongsTo(TeamLoan::class);
    }
}
