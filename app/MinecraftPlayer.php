<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

/**
 * Class MinecraftPlayer
 * @package App
 * @property-read int $id
 * @property string $name
 * @property string $uuid
 * @property-read Accessory[]|Collection $accessories
 * @property-read AccessorySet[]|Collection $accessorySets
 * @property-read Accessory[]|Collection $allAccessories
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

    public function accessories(): MorphToMany
    {
        return $this->morphToMany(Accessory::class, 'accessory_holder');
    }

    public function accessorySets(): BelongsToMany
    {
        return $this->belongsToMany(AccessorySet::class, 'minecraft_player_has_accessory_sets');
    }

    public function getAllAccessoriesAttribute()
    {
        $accessoires = $this->morphToMany(Accessory::class, 'accessory_holder')->get();

        if ($this->patron && $this->patron->tier) {
            $accessoires = $accessoires->merge($this->patron->tier->accessoires);
        }

        foreach ($this->accessorySets as $accessoireSet) {
            $accessoires = $accessoires->merge($accessoireSet->accessoires);
        }

        return $accessoires->unique('id');
    }

    public function hasModAccess(): bool
    {
        if ($this->modSupporterData && $this->modSupporterData->mod_access) {
            return true;
        }

        if ($this->patron && $this->patron->tier && $this->patron->tier->mod_access) {
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

    public function getOrCreateModSupporterData(): ModSupporterData
    {
        return $this->modSupporterData()->exists() ? $this->modSupporterData : $this->modSupporterData()->create();
    }

    public function getOrCreateCraftfallData(): CraftfallData
    {
        return $this->craftfallData()->exists() ? $this->craftfallData : $this->craftfallData()->create();
    }

}
