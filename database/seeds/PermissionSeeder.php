<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'users.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'minecraft_players.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'patreon.manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'accessoires.manage', 'guard_name' => 'web']);
    }
}
