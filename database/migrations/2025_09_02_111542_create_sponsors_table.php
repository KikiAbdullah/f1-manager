<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('funding_amount', 18, 2)->nullable(); // dana yang diberikan
            $table->integer('target_difficulty'); // target difficulty (misal: 1–6 dice roll)
            $table->string('target_description')->nullable(); // misal "Finish 12 besar"
            $table->float('penalty_amount', 18, 2)->nullable(); // denda jika gagal
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('sponsors');
    }
}
