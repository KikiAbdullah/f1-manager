<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('image');
            $table->integer('cornering');
            $table->integer('braking');
            $table->integer('reactions');
            $table->integer('control');
            $table->integer('smoothness');
            $table->integer('adaptability');
            $table->integer('overtaking');
            $table->integer('defending');
            $table->integer('accuracy');
            $table->float('salary_per_race', 18, 2)->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('drivers');
    }
}
