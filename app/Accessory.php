<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Accessoire
 * @package App
 * @property-read int id
 * @property string name
 */
class Accessory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
