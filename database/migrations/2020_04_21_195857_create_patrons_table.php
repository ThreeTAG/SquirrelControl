<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatronsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->unsignedBigInteger('tier_id')->nullable();
            $table->dateTime('interval_start')->nullable();
            $table->unsignedBigInteger('player_id')->nullable();
            $table->timestamps();

            $table->foreign('tier_id')->references('id')->on('patron_tiers');
            $table->foreign('player_id')->references('id')->on('minecraft_players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrons');
    }
}
