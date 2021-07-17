<?php


namespace App;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role as BaseRole;

/**
 * Class Role
 * @package App
 * @property $id
 * @property $name
 * @property $guard_name
 * @property-read CFRoleData|null $craftfallData
 * @property-read Collection $permissions
 */
class Role extends BaseRole
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'guard_name'
    ];

    public function craftfallData(): HasOne
    {
        return $this->hasOne(CFRoleData::class, 'role_id');
    }
}
