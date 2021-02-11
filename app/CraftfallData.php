<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class CraftfallData
 * @package App
 * @property-read int id
 * @property int player_id
 * @property int money
 * @property MinecraftPlayer player
 */
class CraftfallData extends Model
{
    use HasRoles;

    protected $fillable = [
        'player_id',
        'money',
    ];

    public function player()
    {
        return $this->belongsTo(MinecraftPlayer::class, 'player_id');
    }

}
