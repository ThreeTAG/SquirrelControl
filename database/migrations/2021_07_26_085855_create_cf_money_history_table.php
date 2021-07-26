<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfMoneyHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cf_money_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cf_data_id');
            $table->integer('difference');
            $table->integer('new_amount');
            $table->integer('type');
            $table->string('description');
            $table->timestamps();

            $table->foreign('cf_data_id')->references('id')->on('craftfall_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cf_money_history');
    }
}
