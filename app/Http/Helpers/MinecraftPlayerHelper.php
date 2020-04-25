<?php


namespace App\Http\Helpers;


use App\MinecraftPlayer;
use Exception;

class MinecraftPlayerHelper
{
    /**
     * @param $name
     * @return MinecraftPlayer
     * @throws Exception
     */
    public static function getMinecraftPlayer($name)
    {
        if (strlen($name) > 16) {
            if (MojangAPI::isValidUuid($name)) {
                $uuid = MojangAPI::formatUuid($name);
                $username = MojangAPI::getUsername($uuid);

                if ($username) {
                    $player = MinecraftPlayer::where('uuid', $uuid)->first();

                    if (!$player) {
                        $player = MinecraftPlayer::create([
                            'name' => $username,
                            'uuid' => $uuid,
                        ]);
                    } else {
                        $player->name = $username;
                        $player->save();
                    }

                    return $player;
                } else {
                    throw new Exception('No player with that UUID!');
                }
            } else {
                throw new Exception('Not valid UUID!');
            }
        } else {
            $uuid = MojangAPI::getUuid($name);

            if ($uuid) {
                $uuid = MojangAPI::formatUuid($uuid);
                $player = MinecraftPlayer::where('uuid', $uuid)->first();

                if (!$player) {
                    $player = MinecraftPlayer::create([
                        'name' => MojangAPI::getUsername($uuid),
                        'uuid' => $uuid,
                    ]);
                } else {
                    $player->name = MojangAPI::getUsername($uuid);
                    $player->save();
                }

                return $player;
            } else {
                throw new Exception('No player with that name!');
            }
        }


    }
}
