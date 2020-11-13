<?php

namespace App\Api\Controllers;

use App\Api\Response\Response;
use App\MinecraftPlayer;

class MinecraftPlayerController extends Controller
{

    public function getData(Response $response, $uuid)
    {
        /** @var MinecraftPlayer $player */
        $player = MinecraftPlayer::whereUuid($uuid)->first();

        if ($player) {
            $data = [
                'accessoires' => $player->allAccessoires->pluck('name')->toArray(),
                'mod_access' => $player->hasModAccess(),
            ];
            if ($player->getOrCreateModSupporterData()->cloak_path) {
                $data['cloak'] = asset('img/cloaks/' . $player->getOrCreateModSupporterData()->cloak_path);
            }
            return $response->setError(200)->addData($data);
        } else {
            return $response->setError(404)->setMessage('no player with that UUID');
        }
    }

    public function getLegacyData(Response $response)
    {
        $supporters = [];

        foreach (MinecraftPlayer::all() as $player) {
            if ($player->hasModAccess() || $player->getOrCreateModSupporterData()->cloak_path) {
                $data = [
                    'name' => $player->name,
                    'uuid' => $player->uuid,
                    'access' => $player->hasModAccess(),
                ];

                if ($player->getOrCreateModSupporterData()->cloak_path) {
                    $data['cloak'] = asset('img/cloaks/' . $player->getOrCreateModSupporterData()->cloak_path);
                }
                $supporters[] = $data;
            }
        }

        return $response->setError(200)->addData(['supporters' => $supporters]);
    }

}
