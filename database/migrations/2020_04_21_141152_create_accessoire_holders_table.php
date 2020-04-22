<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessoireHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessoire_holders', function (Blueprint $table) {
            $table->unsignedBigInteger('accessoire_id');
            $table->unsignedBigInteger('accessoire_holder_id');
            $table->string('accessoire_holder_type');

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
