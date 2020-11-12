<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class AccessoireSet
 * @package App
 * @property-read $int id
 * @property $string name
 * @property-read $Collection accessoires
 */
class AccessoireSet extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function accessoires(): BelongsToMany
    {
        return $this->morphToMany(Accessoire::class, 'accessoire_holder');
    }
}
