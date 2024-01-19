<?php

namespace App\Api\Controllers;

use App\ModUpdatePost;
use Illuminate\Http\JsonResponse;

class ModUpdatePostController
{

    public function store(): JsonResponse
    {
        $token = request('token');
        $configToken = config('mods.api_token');

        if (!empty($configToken) && $token === $configToken) {
            $mod = trim(request('mod'));
            $version = trim(request('version'));

            if (!config('mods.mods.' . $mod)) {
                return response()->json('Unknown mod', 400);
            }

            if (empty($version)) {
                return response()->json('No version set', 400);
            }

            if (ModUpdatePost::query()->where('mod', $mod)->where('version', $version)->exists()) {
                return response()->json('Entry for that mod and version already exists', 500);
            } else {
                ModUpdatePost::query()->create([
                    'mod' => $mod,
                    'version' => $version,
                    'posted' => 0,
                ]);

                return response()->json('Succesfully scheduled mod update post');
            }
        } else {
            return response()->json('Invalid token', 401);
        }
    }

}
