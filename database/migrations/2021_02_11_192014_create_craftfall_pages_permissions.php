<?php

use App\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class CreateCraftfallPagesPermissions extends Migration
{
    protected $permissions = [
        Permission::WEB_CRAFTFALL_PLAYERS_VIEW => 'Craftfall Moderator|Craftfall Admin',
        Permission::WEB_CRAFTFALL_PLAYERS_MANAGE_AUTHORIZATION => 'Craftfall Admin',
        Permission::WEB_CRAFTFALL_ROLES_MANAGE => 'Craftfall Admin',
        Permission::WEB_CRAFTFALL_WARPS_MANAGE => 'Craftfall Moderator|Craftfall Admin',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission => $roles) {
            $permission = Permission::create(['guard_name' => 'web', 'name' => $permission]);

            foreach (explode('|', $roles) as $roleName) {
                $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();

                if ($role) {
                    $role->givePermissionTo($permission);
                } else {
                    $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
                    $role->givePermissionTo($permission);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('craftfall_pages_permissions');
    }
}
