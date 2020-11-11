<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Class MinecraftPlayer
 * @package App
 * @property-read int $id
 * @property string $name
 * @property string $uuid
 * @property-read Collection $accessoires
 * @property-read Collection $allAccessoires
 * @property-read ModSupporterData|null $modSupporterData
 * @property-read CraftfallData|null $craftfallData
 * @property-read Patron|null $patron
 */
class MinecraftPlayer extends Model
{
    protected $fillable = [
        'name',
        'uuid',
    ];

    public function accessoires()
    {
        return $this->morphToMany(Accessoire::class, 'accessoire_holder');
    }

    public function getAllAccessoiresAttribute()
    {
        $accessoires = $this->morphToMany(Accessoire::class, 'accessoire_holder')->get();

        if($this->patron && $this->patron->tier) {
            $accessoires = $accessoires->merge($this->patron->tier->accessoires);
        }

        return $accessoires;
    }

    public function hasModAccess()
    {
        if($this->modSupporterData && $this->modSupporterData->mod_access) {
            return true;
        }

        if($this->patron && $this->patron->tier && $this->patron->tier->mod_access) {
            return true;
        }

        return false;
    }

    public function modSupporterData(): HasOne
    {
        return $this->hasOne(ModSupporterData::class, 'player_id');
    }

    public function craftfallData(): HasOne
    {
        return $this->hasOne(CraftfallData::class, 'player_id');
    }

    public function patron(): HasOne
    {
        return $this->hasOne(Patron::class, 'player_id');
    }

    public function getOrCreateModSupporterData()
    {
        return $this->modSupporterData ?? $this->modSupporterData()->create();
    }

    public function getOrCreateCraftfallData()
    {
        return $this->craftfallData ?? $this->craftfallData()->create();
    }

}
