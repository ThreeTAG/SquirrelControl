<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsRewardColumnToAccessorySetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::rename('accessoires', 'accessories');
        Schema::rename('accessoire_holders', 'accessory_holders');
        Schema::rename('accessoire_sets', 'accessory_sets');
        Schema::rename('minecraft_player_has_accessoire_sets', 'minecraft_player_has_accessory_sets');

        Schema::table('accessory_holders', function (Blueprint $table) {
            $table->renameColumn('accessoire_id', 'accessory_id');
            $table->renameColumn('accessoire_holder_id', 'accessory_holder_id');
            $table->renameColumn('accessoire_holder_type', 'accessory_holder_type');
        });

        Schema::table('minecraft_player_has_accessory_sets', function (Blueprint $table) {
            $table->renameColumn('accessoire_set_id', 'accessory_set_id');
        });

        Schema::table('accessory_sets', function (Blueprint $table) {
            $table->boolean('is_reward')->default(false)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('accessory_sets', function (Blueprint $table) {
            $table->dropColumn('is_reward');
        });

        Schema::table('accessory_holders', function (Blueprint $table) {
            $table->renameColumn('accessory_id', 'accessoire_id');
            $table->renameColumn('accessory_holder_id', 'accessoire_holder_id');
            $table->renameColumn('accessory_holder_type', 'accessoire_holder_type');
        });

        Schema::table('minecraft_player_has_accessory_sets', function (Blueprint $table) {
            $table->renameColumn('accessory_set_id', 'accessoire_set_id');
        });

        Schema::rename('accessories', 'accessoires');
        Schema::rename('accessory_holders', 'accessoire_holders');
        Schema::rename('accessory_sets', 'accessoire_sets');
        Schema::rename('minecraft_player_has_accessory_sets', 'minecraft_player_has_accessoire_sets');
    }
}
