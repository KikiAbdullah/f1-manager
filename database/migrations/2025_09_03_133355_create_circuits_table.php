<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCircuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circuits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('length_km')->nullable();
            $table->integer('laps')->default(1);
            $table->integer('straight_length')->default(1);  //butuh Power & Efficiency
            $table->integer('corner_density')->default(1);  //butuh Downforce & Skill.
            $table->integer('tyre_wear_level')->default(1);  //butuh Tyre Management.
            $table->integer('brake_wear_level')->default(1);  //butuh Reliability + Driver Stamina.
            $table->integer('overtake_difficulty')->default(1);
            $table->integer('drs_zones')->default(1);
            $table->integer('avg_speed')->default(1);
            $table->integer('downforce_level')->default(1);
            $table->integer('grip_level')->default(1);
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
        Schema::dropIfExists('circuits');
    }
}
