<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCraftfallDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('craftfall_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->bigInteger('money');
            $table->dateTime('first_join');
            $table->dateTime('last_join');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('craftfall_data');
    }
}
