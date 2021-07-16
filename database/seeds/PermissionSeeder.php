<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
