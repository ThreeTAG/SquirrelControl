<?php

namespace Database\Seeders;

use App\Accessory;
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
        Accessory::create(['name' => 'threecore:winter_soldier_arm']);
        Accessory::create(['name' => 'threecore:herobrine_eyes']);
        Accessory::create(['name' => 'threecore:wooden_leg']);
        Accessory::create(['name' => 'threecore:hyperion_arm']);
        Accessory::create(['name' => 'threecore:strawhat']);
    }
}
