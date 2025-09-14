<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualifyingResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifying_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('schedule_id')->nullable();
            $table->bigInteger('driver_id')->nullable();
            $table->integer('position')->nullable();
            $table->float('q1_time')->nullable();
            $table->float('q2_time')->nullable();
            $table->float('q3_time')->nullable();
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
        Schema::dropIfExists('qualifying_results');
    }
}
