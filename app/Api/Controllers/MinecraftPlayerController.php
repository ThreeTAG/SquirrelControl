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
                'accessoires' => $player->accessoires->pluck('name')->toArray(),
                'mod_access' => $player->hasModAccess(),
                'cloak' => '',
            ];
            return $response->setError(200)->addData($data);
        } else {
            return $response->setError(404)->setMessage('no player with that UUID');
        }
    }

}
