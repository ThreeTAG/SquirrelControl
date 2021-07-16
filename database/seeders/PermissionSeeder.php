<?php

namespace Database\Seeders;

use App\Permission;
use Illuminate\Database\Seeder;
use ReflectionClass;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $refl = new ReflectionClass(Permission::class);

        foreach ($refl->getConstants() as $name => $value) {
            if (substr($name, 0, 4) === 'WEB_') {
                Permission::findOrCreate($value);
            }
        }
    }
}
