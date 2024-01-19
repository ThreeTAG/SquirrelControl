<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $mod
 * @property string $version
 * @property string|null $curseforge_forge_download
 * @property string|null $curseforge_fabric_download
 * @property string|null $modrinth_forge_download
 * @property string|null $modrinth_fabric_download
 * @property boolean $posted
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModUpdatePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'mod',
        'version',
        'curseforge_forge_download',
        'curseforge_fabric_download',
        'modrinth_forge_download',
        'modrinth_fabric_download',
        'posted',
    ];
}
