<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_loan_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_loan_id');  // relasi ke pivot loan
            $table->double('amount', 18, 2);             // nominal cicilan
            $table->date('due_date');                    // tanggal jatuh tempo
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_loan_payments');
    }
}
