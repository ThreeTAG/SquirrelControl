<?php

namespace App\Api\Controllers;

use App\Api\Response\Response;

class ForgeUpdateJsonController
{

    public function updateJson(string $mod): array
    {
        $modrinthLink = "https://api.modrinth.com/updates/$mod/forge_updates.json";
        $data = json_decode(file_get_contents($modrinthLink), true);

        $promos = data_get($data, 'promos');
        foreach ($promos as $key => $value) {
            $promos[$key] = explode('+', $value)[0];
        }

        $data['promos'] = $promos;
        return $data;
    }

}
