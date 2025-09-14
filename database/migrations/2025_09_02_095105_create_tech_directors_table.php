<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechDirectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_directors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('chassis')->default(1); // 1–100
            $table->integer('powertrain')->default(1);  // 1–100
            $table->integer('durability')->default(1);  // 1–100
            $table->integer('suspension')->default(1);  // 1–100
            $table->integer('cooling')->default(1);  // 1–100
            $table->integer('innovation')->default(1);  // 1–100
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
        Schema::dropIfExists('tech_directors');
    }
}
