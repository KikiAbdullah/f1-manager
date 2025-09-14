<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamSponsorTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_sponsor_targets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_sponsor_id');          // relasi ke pivot sponsor
            $table->string('description');                   // contoh: "Finish at least P12"
            $table->integer('difficulty');                   // misal 1–5
            $table->date('due_date');                        // kapan target ini harus dicapai
            $table->enum('status', ['pending', 'achieved', 'failed'])->default('pending');
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
        Schema::dropIfExists('team_sponsor_targets');
    }
}
