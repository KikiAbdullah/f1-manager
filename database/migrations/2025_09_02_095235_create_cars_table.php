<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_id');
            $table->string('name');
            $table->bigInteger('engine_id')->nullable();
            $table->bigInteger('tech_director_id')->nullable();
            $table->bigInteger('aero_chief_id')->nullable();
            $table->bigInteger('race_engineer_id')->nullable();
            $table->integer('top_speed')->default(1); //Engine.Power + (Aero.Efficiency / 2) – (Aero.Downforce / 3)
            $table->integer('cornering')->default(1); //Aero.Downforce + (Tech.Engineering / 2) – (Engine.Power / 3)
            $table->integer('reliability')->default(1); //Engine.Reliability + (Tech.Engineering / 2) – (Innovation Risk)
            $table->integer('fuel_efficiency')->default(1); //Engine.FuelEfficiency + (Aero.Efficiency / 2)
            $table->integer('tyre_management')->default(1); //RaceEngineer.Strategy + Driver.Experience/2
            $table->integer('cooling')->default(1); //Engine.HeatManagement + Tech.Engineering/2
            $table->integer('acceleration')->default(1);
            $table->integer('braking')->default(1);
            $table->integer('aero_efficiency')->default(1);
            $table->integer('adaptability')->default(1);
            $table->integer('pit_stop_speed')->default(1);
            $table->integer('overall_score')->default(1);
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
        Schema::dropIfExists('cars');
    }
}
