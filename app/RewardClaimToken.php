<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $token
 * @property string $email
 * @property int|null $minecraft_player_id
 * @property MinecraftPlayer|null $minecraftPlayer
 * @property bool $claimed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class RewardClaimToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'email',
        'minecraft_player_id',
    ];

    public function getClaimedAttribute(): bool
    {
        return !is_null($this->minecraft_player_id);
    }
}
