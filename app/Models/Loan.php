<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'lender_name',
        'loan_amount',
        'interest_rate',
        'season_duration',
        'repayment_per_season',
        'created_by'
    ];

    public function teams()
    {
        return $this->hasMany(TeamLoan::class);
    }
}
