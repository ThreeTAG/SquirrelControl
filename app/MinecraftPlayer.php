<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * Class MinecraftPlayer
 * @package App
 * @property-read int $id
 * @property string $name
 * @property string $uuid
 * @property-read Accessoire[] $accessoires
 * @property-read AccessoireSet[] $accessoireSets
 * @property-read Accessoire[] $allAccessoires
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

    public function accessoires(): MorphMany
    {
        return $this->morphToMany(Accessoire::class, 'accessoire_holder');
    }

    public function accessoireSets(): BelongsToMany
    {
        return $this->belongsToMany(AccessoireSet::class, 'minecraft_player_has_accessoire_sets');
    }

    public function getAllAccessoiresAttribute()
    {
        $accessoires = $this->morphToMany(Accessoire::class, 'accessoire_holder')->get();

        if ($this->patron && $this->patron->tier) {
            $accessoires = $accessoires->merge($this->patron->tier->accessoires);
        }

        foreach ($this->accessoireSets as $accessoireSet) {
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
        return $this->modSupporterData ?? $this->modSupporterData()->create();
    }

    public function getOrCreateCraftfallData(): CraftfallData
    {
        return $this->craftfallData ?? $this->craftfallData()->create();
    }

}
