<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaceResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('schedule_id');
            $table->bigInteger('driver_id');
            $table->integer('lap_number');
            $table->float('sector1_time')->nullable();
            $table->float('sector2_time')->nullable();
            $table->float('sector3_time')->nullable();
            $table->float('lap_time')->nullable();
            $table->tinyInteger('dnf');
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
        Schema::dropIfExists('race_results');
    }
}
