<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class CraftfallData
 * @package App
 * @property-read int $id
 * @property int $player_id
 * @property int $money
 * @property Carbon $first_join
 * @property Carbon $last_join
 * @property-read MinecraftPlayer $player
 * @property-read Collection $moneyHistories
 */
class CraftfallData extends Model
{
    use HasRoles;

    protected $fillable = [
        'player_id',
        'money',
        'first_join',
        'last_join',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(MinecraftPlayer::class, 'player_id');
    }

    public function moneyHistories(): HasMany
    {
        return $this->hasMany(MoneyHistory::class, 'cf_data_id');
    }

}
