<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaceEngineersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_engineers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('strategy')->default(1);      // 1–100
            $table->integer('tyre_management')->default(1); // 1–100
            $table->integer('communication')->default(1); // 1–100
            $table->integer('adaptability')->default(1); // 1–100
            $table->integer('fuel_management')->default(1); // 1–100
            $table->integer('data_analysis')->default(1); // 1–100
            $table->float('salary', 18, 2)->nullable();
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
        Schema::dropIfExists('race_engineers');
    }
}
