<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAeroChiefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aero_chiefs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('front_aero')->default(1); // 1–100
            $table->integer('rear_aero')->default(1);          // 1–100
            $table->integer('drag_efficiency')->default(1);          // 1–100
            $table->integer('wind_tunnel')->default(1);          // 1–100
            $table->integer('ground_effect')->default(1);          // 1–100
            $table->integer('aero_innovation')->default(1);          // 1–100
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
        Schema::dropIfExists('aero_chiefs');
    }
}
