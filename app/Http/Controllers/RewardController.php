<?php

namespace App\Http\Controllers;

use App\AccessorySet;
use App\Http\Helpers\MinecraftPlayerHelper;
use App\Http\Helpers\MojangAPI;
use App\MinecraftPlayer;
use App\RewardClaimToken;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RewardController extends Controller
{

    public function view(string $token): View|Factory|string|Application
    {
        if (RewardClaimToken::query()->where('token', $token)->whereNull('minecraft_player_id')->exists()) {
            return view('external.rewards.claim', compact('token'));
        } else {
            return 'Invalid token';
        }
    }

    public function claim(string $token, Request $request): JsonResponse
    {
        if (!RewardClaimToken::query()->where('token', $token)->whereNull('minecraft_player_id')->exists()) {
            return response()->json(['message' => 'Invalid token!'], 400);
        }

        $username = trim($request->get('username'));

        try {
            $player = $this->getPlayer($username);
            /** @var RewardClaimToken $token */
            $token = RewardClaimToken::query()->where('token', $token)->whereNull('minecraft_player_id')->first();
            $token->update([
                'minecraft_player_id' => $player->id,
            ]);

            $player->accessorySets()->attach(AccessorySet::query()->where('is_reward', true)->get());

            return response()->json(['message' => 'Successfully claimed rewards!'], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Invalid player name!'], 400);
        }
    }

    /**
     * @throws Exception
     */
    private function getPlayer($name): MinecraftPlayer
    {
        if(app()->environment() == 'local') {
            /** @var MinecraftPlayer $player */
            $player = MinecraftPlayer::query()->firstOrCreate([
                'name' => $name,
            ], ['uuid' => Str::uuid()]);
        } else {
            $player = MinecraftPlayerHelper::getMinecraftPlayer($name);
        }

        return $player;
    }

}
