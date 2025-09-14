<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnginesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('power')->default(1);      // 1–100
            $table->tinyInteger('reliability')->default(1); // 1–100
            $table->tinyInteger('heat_management')->default(1); // 1–100
            $table->tinyInteger('fuel_efficiency')->default(1); // 1–100
            $table->tinyInteger('drivability')->default(1); // 1–100
            $table->tinyInteger('hybrid_system')->default(1); // 1–100
            $table->tinyInteger('innovation')->default(1); // 1–100
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
        Schema::dropIfExists('engines');
    }
}
