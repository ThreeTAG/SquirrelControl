<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class PatronTier
 * @package App
 * @property-read $int id
 * @property $string name
 * @property boolean $mod_access
 * @property-read Accessoire[]|Collection accessoires
 */
class PatronTier extends Model
{
    protected $fillable = [
        'name',
        'mod_access',
    ];

    public function accessoires(): BelongsToMany
    {
        return $this->morphToMany(Accessoire::class, 'accessoire_holder');
    }
}
