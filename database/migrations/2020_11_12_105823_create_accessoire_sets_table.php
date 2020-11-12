<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessoireSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessoire_sets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('minecraft_player_has_accessoire_sets', function (Blueprint $table) {
            $table->unsignedBigInteger('minecraft_player_id');
            $table->unsignedBigInteger('accessoire_set_id');

            $table->foreign('minecraft_player_id')->references('id')->on('minecraft_players')->onDelete('cascade');
            $table->foreign('accessoire_set_id')->references('id')->on('accessoire_sets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessoire_sets');
        Schema::dropIfExists('minecraft_player_has_accessoire_sets');
    }
}
