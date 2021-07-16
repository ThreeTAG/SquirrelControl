<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;

/**
 * Class Ban
 * @package App
 * @property int $player_id
 * @property-read MinecraftPlayer $player
 * @property int $created_by_id
 * @property-read User $createdBy
 * @property int|null $revoked_by_id
 * @property-read User|null $revokedBy
 * @property string $reason
 * @property Carbon|null $until
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Ban extends Model
{
    use Commentable;

    public $table = 'cf_bans';

    protected $fillable = [
        'player_id',
        'created_by_id',
        'revoked_by_id',
        'reason',
        'until',
    ];

    public function player()
    {
        return $this->belongsTo(MinecraftPlayer::class, 'player_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function revokedBy()
    {
        return $this->belongsTo(User::class, 'revoked_by_id');
    }
}
