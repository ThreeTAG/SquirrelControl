<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CFRoleData
 * @package App
 * @property int $role_id
 * @property-read Role $role
 * @property string $prefix
 */
class CFRoleData extends Model
{

    public $table = 'cf_role_data';

    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'prefix',
    ];

    protected $casts = [
        'prefix' => 'array',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
