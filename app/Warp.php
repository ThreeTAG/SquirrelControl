<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $name
 * @property string $dimension
 * @property float $x
 * @property float $y
 * @property float $z
 */
class Warp extends Model
{
    protected $fillable = [
        'name',
        'dimension',
        'x',
        'y',
        'z',
    ];
}
