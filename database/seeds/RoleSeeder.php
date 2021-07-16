<?php

use App\Permission;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoleWithPerms('Admin', Permission::all());
        $this->createRoleWithPerms('Craftfall Admin', Permission::WEB_CRAFTFALL_PLAYERS_VIEW, Permission::WEB_CRAFTFALL_PLAYERS_MANAGE_AUTHORIZATION, Permission::WEB_CRAFTFALL_ROLES_MANAGE, Permission::WEB_CRAFTFALL_WARPS_MANAGE);
        $this->createRoleWithPerms('Craftfall Moderator', Permission::WEB_CRAFTFALL_PLAYERS_VIEW, Permission::WEB_CRAFTFALL_WARPS_MANAGE);
    }

    public function createRoleWithPerms($roleName, ...$permissions)
    {
        /** @var Role $role */
        $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
        if (!$role) {
            $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
        }
        $role->givePermissionTo($permissions);
    }

}
