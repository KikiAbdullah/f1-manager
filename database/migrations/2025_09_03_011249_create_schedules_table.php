<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('race_date')->nullable();
            $table->bigInteger('circuit_id')->nullable();
            $table->integer('season')->nullable()->comment('year');
            $table->string('weather_forecast')->nullable()->comment('sunny', 'rainy', 'cloudy');
            $table->string('actual_weather')->nullable()->comment('generate by click');
            $table->string('air_temp')->nullable()->comment('generate by click');
            $table->string('track_temp')->nullable()->comment('generate by click');
            $table->integer('laps')->nullable();
            $table->integer('safety_car_probability')->nullable();
            $table->integer('average_pit_time')->nullable();
            $table->string('status')->nullable()->comment('upcoming', 'completed');
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
        Schema::dropIfExists('schedules');
    }
}
