<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class PatronTier
 * @package App
 * @property-read int id
 * @property string name
 * @property Collection accessoires
 */
class PatronTier extends Model
{
    protected $fillable = [
        'name',
    ];

    public function accessoires(): BelongsToMany
    {
        return $this->morphToMany(Accessoire::class, 'accessoire_holder');
    }
}
