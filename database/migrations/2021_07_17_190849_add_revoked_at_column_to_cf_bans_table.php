<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRevokedAtColumnToCfBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cf_bans', function (Blueprint $table) {
            $table->dateTime('revoked_at')->nullable()->after('revoked_by_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cf_bans', function (Blueprint $table) {
            $table->dropColumn('revoked_at');
        });
    }
}
