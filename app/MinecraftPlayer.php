<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Class MinecraftPlayer
 * @package App
 * @property-read int id
 * @property string name
 * @property string uuid
 * @property Collection accessoires
 * @property CraftfallData craftfallData
 * @property Patron patron
 */
class MinecraftPlayer extends Model
{
    protected $fillable = [
        'name',
        'uuid',
    ];

    public function getAccessoiresAttribute()
    {
        $accessoires = $this->morphToMany(Accessoire::class, 'accessoire_holder')->get();

        if($this->patron && $this->patron->tier) {
            $accessoires = $accessoires->merge($this->patron->tier->accessoires);
        }

        return $accessoires;
    }

    public function craftfallData(): HasOne
    {
        return $this->hasOne(CraftfallData::class, 'player_id');
    }

    public function patron(): HasOne
    {
        return $this->hasOne(Patron::class, 'player_id');
    }

}
