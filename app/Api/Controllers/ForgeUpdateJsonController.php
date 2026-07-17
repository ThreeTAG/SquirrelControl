<?php

namespace App\Api\Controllers;

use App\Api\Response\Response;
use Illuminate\Support\Facades\Cache;

class ForgeUpdateJsonController
{

    public function updateJson(Response $response, string $mod)
    {
        return Cache::remember("forge_updates:{$mod}", 300, function () use ($response, $mod) {
            $modrinthLink = "https://api.modrinth.com/updates/" . urlencode($mod) . "/forge_updates.json";

            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                ],
            ]);
            $content = @file_get_contents($modrinthLink, false, $context);

            if ($content === false) {
                return $response->setError(502)->setMessage('Modrinth API not reachable');
            }

            $data = json_decode($content, true);

            if (!is_array($data)) {
                return $response->setError(502)->setMessage('Invalid response from Modrinth API');
            }

            $promos = data_get($data, 'promos', []);
            foreach ($promos as $key => $value) {
                $promos[$key] = explode('+', $value)[0];
            }

            $data['promos'] = $promos;
            return $data;
        });
    }

}
