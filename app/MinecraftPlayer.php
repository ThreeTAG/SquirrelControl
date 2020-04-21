<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Class MinecraftPlayer
 * @package App
 * @property int id
 * @property string name
 * @property string uuid
 * @property Collection accessoires
 * @property CraftfallData craftfallData
 */
class MinecraftPlayer extends Model
{
    protected $fillable = [
        'name',
        'uuid',
    ];

    public function accessoires(): BelongsToMany
    {
        return $this->belongsToMany(Accessoire::class, 'minecraft_player_accessoires', 'player_id');
    }

    public function craftfallData(): HasOne
    {
        return $this->hasOne(CraftfallData::class, 'player_id');
    }

}
