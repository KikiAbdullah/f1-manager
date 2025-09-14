<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_finances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_id');
            $table->string('description');           // contoh: "Sponsor Petronas", "Loan dari F1 Bank", "Bayar Loan", "Develop Mobil"
            $table->double('amount', 18, 2);         // nominal uang
            $table->enum('type', ['in', 'out']);     // in = uang masuk, out = uang keluar
            $table->date('transaction_date');        // tanggal transaksi
            $table->string('category')->nullable();  // opsional: sponsor, loan, loan_payment, develop_car, develop_driver, damage, gaji_driver
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
        Schema::dropIfExists('team_finances');
    }
}
