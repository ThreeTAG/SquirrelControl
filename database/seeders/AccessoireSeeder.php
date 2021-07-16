<?php

namespace Database\Seeders;

use App\Accessoire;
use Illuminate\Database\Seeder;

class AccessoireSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Accessoire::create(['name' => 'threecore:winter_soldier_arm']);
        Accessoire::create(['name' => 'threecore:herobrine_eyes']);
        Accessoire::create(['name' => 'threecore:wooden_leg']);
        Accessoire::create(['name' => 'threecore:hyperion_arm']);
        Accessoire::create(['name' => 'threecore:strawhat']);
    }
}
