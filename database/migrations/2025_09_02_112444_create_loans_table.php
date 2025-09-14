<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('lender_name'); // nama pemberi pinjaman (Bank, Investor, dll)
            $table->float('loan_amount', 18, 2)->nullable();
            $table->integer('interest_rate'); // persen bunga
            $table->integer('season_duration'); // lama musim (berapa race atau musim)
            $table->float('repayment_per_season', 18, 2)->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
