<?php

namespace App;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'guard_name'
    ];

    const WEB_USERS_MANAGE = 'users.manage';
    const WEB_MINECRAFT_PLAYERS_MANAGE = 'minecraft_players.manage';
    const WEB_ROLES_MANAGE = 'roles.manage';
    const WEB_PATREON_MANAGE = 'patreon.manage';
    const WEB_ACCESSOIRES_MANAGE = 'accessoires.manage';

    const WEB_CRAFTFALL_PLAYERS_VIEW = 'craftfall.players.view';
    const WEB_CRAFTFALL_PLAYERS_MANAGE_AUTHORIZATION = 'craftfall.players.manage.authorization';
    const WEB_CRAFTFALL_ROLES_MANAGE = 'craftfall.roles.manage';
    const WEB_CRAFTFALL_WARPS_MANAGE = 'craftfall.warps.manage';
}
