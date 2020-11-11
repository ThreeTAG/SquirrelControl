<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CraftfallData
 * @package App
 * @property-read int $id
 * @property int $player_id
 * @property boolean $mod_access
 * @property string $cloak_path
 * @property MinecraftPlayer $player
 */
class ModSupporterData extends Model
{
    protected $fillable = [
        'player_id',
        'mod_access',
        'cloak_path',
    ];

    public function player()
    {
        return $this->belongsTo(MinecraftPlayer::class, 'player_id');
    }
}
