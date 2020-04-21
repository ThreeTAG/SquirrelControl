<?php

namespace App\Api\Controllers;

use App\Api\Response\Response;
use App\MinecraftPlayer;

class MinecraftPlayerController extends Controller
{

    public function getAccessoires(Response $response, $uuid)
    {
        /** @var MinecraftPlayer $player */
        $player = MinecraftPlayer::whereUuid($uuid)->first();

        if($player) {
            return $response->setError(200)->addData($player->accessoires->pluck('name')->toArray());
        } else {
            return $response->setError(404)->setMessage('no player with that UUID');
        }
    }

}
