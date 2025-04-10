<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/player/{uuid}', 'MinecraftPlayerController@getData');
Route::get('/legacy/data', 'MinecraftPlayerController@getLegacyData');
Route::post('/mod-update-post', 'ModUpdatePostController@store');
Route::get('/forge_updates/{mod}', 'ForgeUpdateJsonController@updateJson');
Route::post('/webhook/rewards', 'WebhookController@rewards')->name('webhook.rewards');
