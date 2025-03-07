<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class AccessoireSet
 * @package App
 * @property-read int $id
 * @property string $name
 * @property bool $is_reward
 * @property-read Accessory[]|Collection $accessories
 */
class AccessorySet extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_reward',
    ];

    protected $casts = [
        'is_reward' => 'boolean',
    ];

    public function accessories(): BelongsToMany
    {
        return $this->morphToMany(Accessory::class, 'accessory_holder');
    }
}
