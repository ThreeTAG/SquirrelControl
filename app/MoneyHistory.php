<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MoneyHistory
 * @package App
 * @property-read int $id
 * @property int $cf_data_id
 * @property-read CraftfallData $craftfallData
 * @property-read MinecraftPlayer $player
 * @property int $difference
 * @property int $new_amount
 * @property int $type
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class MoneyHistory extends Model
{
    const TYPE_SENT_TO = 0;
    const TYPE_RECEIVED_FROM = 1;
    const TYPE_CHANGED_BY_STAFF = 2;
    const TYPE_QUEST_REWARD = 3;
    const TYPE_SOLD_ITEMS = 4;
    const TYPE_TELEPORT_COST = 5;
    const TYPE_CLAIM_COST = 6;

    public $table = 'cf_money_history';

    public $fillable = [
        'cf_data_id',
        'new_amount',
        'difference',
        'type',
        'description',
    ];

    public function craftfallData(): BelongsTo
    {
        return $this->belongsTo(CraftfallData::class, 'cf_data_id');
    }

    public function getPlayerAttribute(): MinecraftPlayer
    {
        return $this->craftfallData->player;
    }
}
