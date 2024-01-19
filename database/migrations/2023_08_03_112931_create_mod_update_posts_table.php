<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModUpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mod_update_posts', function (Blueprint $table) {
            $table->id();
            $table->string('mod');
            $table->string('version');
            $table->string('curseforge_forge_download')->nullable();
            $table->string('curseforge_fabric_download')->nullable();
            $table->string('modrinth_forge_download')->nullable();
            $table->string('modrinth_fabric_download')->nullable();
            $table->boolean('posted')->default(false);
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
        Schema::dropIfExists('mod_update_posts');
    }
}
