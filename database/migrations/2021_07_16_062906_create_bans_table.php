<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cf_bans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('created_by_id');
            $table->unsignedBigInteger('revoked_by_id')->nullable();
            $table->longText('reason');
            $table->dateTime('until')->nullable();
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('minecraft_players');
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->foreign('revoked_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cf_bans');
    }
}
