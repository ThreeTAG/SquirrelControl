<?php

return [

    'curseforge_api_token' => env('CURSEFORGE_API_TOKEN'),

    'bot_token' => env('MOD_UPDATE_BOT_TOKEN'),

    'api_token' => env('MOD_UPDATE_API_TOKEN'),

    'channel_id' => env('MOD_UPDATE_CHANNEL_ID'),

    'modrinth_emoji' => env('MOD_UPDATE_MODRINTH_EMOJI'),

    'curseforge_emoji' => env('MOD_UPDATE_CURSEFORGE_EMOJI'),

    'mods' => [
        'palladium' => [
            'curseforge_id' => 963363,
            'modrinth_id' => 'lt2zd42r',
            'color' => '2eb2f8',
        ],
        'pymtech' => [
            'curseforge_id' => 316946,
            'modrinth_id' => '123',
            'color' => '#ff0000',
        ],
        'pantheonsent' => [
            'curseforge_id' => 968457,
            'modrinth_id' => 'SIKMQqt0',
            'color' => '#f9dd55',
        ],
        'triadtech' => [
            'curseforge_id' => 1053056,
            'modrinth_id' => 'fQMVANbQ',
            'color' => '#59ecff',
        ],
    ]

];
