<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Patron
 * @package App
 * @property-read int id
 * @property string name
 * @property int tier_id
 * @property PatronTier tier
 * @property DateTime interval_start
 * @property int player_id
 * @property MinecraftPlayer player
 */
class Patron extends Model
{
    protected $fillable = [
        'name',
        'email',
        'tier',
        'player_id',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(MinecraftPlayer::class, 'player_id');
    }

    public function tier(): BelongsTo
    {
        return $this->belongsTo(PatronTier::class, 'tier_id');
    }

}
