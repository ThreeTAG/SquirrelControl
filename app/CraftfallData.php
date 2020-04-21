<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CraftfallData
 * @package App
 * @property int id
 * @property int player_id
 * @property int money
 * @property MinecraftPlayer player
 */
class CraftfallData extends Model
{
    protected $fillable = [
        'player_id',
        'money',
    ];

    public function player()
    {
        return $this->belongsTo(MinecraftPlayer::class, 'player_id');
    }

}
