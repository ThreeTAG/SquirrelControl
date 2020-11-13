<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModSupporterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_supporter_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->boolean('mod_access')->default(false)->nullable();
            $table->string('cloak_path')->nullable();

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
        Schema::dropIfExists('mod_supporter_data');
    }
}
