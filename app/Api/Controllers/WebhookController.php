<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\ClaimRewardNotification;
use App\RewardClaimToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class WebhookController extends Controller
{

    public function rewards(Request $request): JsonResponse
    {
        if ($request->get('verification_token') !== config('kofi.webhook_verification_token')
            || !in_array($request->get('type'), ['Donation', 'Subscription'])) {
            return response()->json([], 401);
        }

        $email = $request->get('email');

        // Delete any unclaimed
        RewardClaimToken::query()->where('email', $email)->whereNull('minecraft_player_id')->delete();

        // Check if already claimed something
        if (RewardClaimToken::query()->where('email', $email)->whereNotNull('minecraft_player_id')->exists()) {
            return response()->json(['message' => 'Rewards already claimed!'], 200);
        }

        // Create new token
        /** @var RewardClaimToken $reward */
        $reward = RewardClaimToken::query()->create([
            'email' => $email,
            'token' => $this->generateToken(),
        ]);

        // Send mail
        if (str_ends_with($email, '@example.com')) {
            $email = 'lucas@threetag.net';
        }

        Notification::route('mail', $email)->notify(new ClaimRewardNotification($reward->token));

        return response()->json(['message' => 'Reward claim mail sent'], 201);
    }

    private function generateToken(): string
    {
        $token = Str::random(64);

        if (RewardClaimToken::query()->where('token', $token)->exists()) {
            return $this->generateToken();
        } else {
            return $token;
        }
    }

}
