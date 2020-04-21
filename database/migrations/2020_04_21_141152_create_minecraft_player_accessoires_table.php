<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinecraftPlayerAccessoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minecraft_player_accessoires', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('accessoire_id');
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('minecraft_players');
            $table->foreign('accessoire_id')->references('id')->on('accessoires');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('minecraft_player_accessoires');
    }
}
