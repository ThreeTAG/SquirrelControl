<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::group(['middleware' => ['web']], function () {
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/user/{user}', 'UserController@edit')->name('users.edit');
    Route::post('/user/{user}', 'UserController@update')->name('users.update');

    Route::get('/roles', 'RoleController@index')->name('roles.index');
    Route::get('/role/{role}', 'RoleController@edit')->name('roles.edit');
    Route::post('/role/{role}', 'RoleController@update')->name('roles.update');

    Route::get('/minecraft-players', 'MinecraftPlayerController@index')->name('minecraft-players.index');
    Route::get('/minecraft-players/search/{search?}', 'MinecraftPlayerController@search')->name('minecraft-players.search');
    Route::post('/minecraft-players/add', 'MinecraftPlayerController@store')->name('minecraft-players.store');
    Route::get('/minecraft-players/{player}', 'MinecraftPlayerController@edit')->name('minecraft-players.edit');
    Route::post('/minecraft-players/{player}', 'MinecraftPlayerController@update')->name('minecraft-players.update');

    Route::get('/rewards/{token}', 'RewardController@view')->name('rewards.view');
    Route::post('/rewards/{token}/confirm', 'RewardController@claim')->name('rewards.claim');

    Route::get('/patreon', 'PatreonController@index')->name('patreon.index');
    Route::get('/patreon/tier/{tier}', 'PatreonController@editTier')->name('patreon.tier.edit');
    Route::post('/patreon/tier/{tier}', 'PatreonController@updateTier')->name('patreon.tier.update');
    Route::post('/patreon/patron/{patron}', 'PatreonController@updatePatronPlayer')->name('patreon.patron.update');

    Route::get('/accessories', 'AccessoryController@index')->name('accessories.index');
    Route::post('/accessories/add', 'AccessoryController@store')->name('accessories.store');
    Route::post('/accessories/{accessory}/delete', 'AccessoryController@destroy')->name('accessories.destroy');

    Route::get('/accessories/sets', 'AccessorySetController@index')->name('accessories.sets.index');
    Route::post('/accessories/sets/add', 'AccessorySetController@store')->name('accessories.sets.store');
    Route::get('/accessories/sets/{set}', 'AccessorySetController@edit')->name('accessories.sets.edit');
    Route::post('/accessories/sets/{set}', 'AccessorySetController@update')->name('accessories.sets.update');

    Route::prefix('craftfall')->name('craftfall.')->group(function () {
        Route::get('/', 'HomeController@craftfall')->name('home');
        Route::post('/command', 'HomeController@command')->name('command');

        Route::get('/roles', 'Craftfall\CFRoleController@index')->name('roles.index');
        Route::get('/role/{role}', 'Craftfall\CFRoleController@edit')->name('roles.edit');
        Route::post('/role/add', 'Craftfall\CFRoleController@store')->name('roles.store');
        Route::post('/role/{role}', 'Craftfall\CFRoleController@update')->name('roles.update');

        Route::get('/players', 'Craftfall\CFPlayerController@index')->name('players.index');
        Route::get('/players/search/{search?}', 'Craftfall\CFPlayerController@search')->name('players.search');
        Route::get('/players/{player}', 'Craftfall\CFPlayerController@edit')->name('players.edit');
        Route::post('/players/{player}', 'Craftfall\CFPlayerController@update')->name('players.update');

        Route::get('/bans', 'Craftfall\BanController@index')->name('bans.index');
        Route::get('/bans/search/{search?}', 'Craftfall\BanController@search')->name('bans.search');
        Route::get('/ban/create/{name?}', 'Craftfall\BanController@create')->name('bans.create');
        Route::get('/ban/{ban}', 'Craftfall\BanController@view')->name('bans.view');
        Route::post('/ban/{ban}/comment', 'Craftfall\BanController@postComment')->name('bans.comment');
        Route::post('/ban/store', 'Craftfall\BanController@store')->name('bans.store');
        Route::post('/ban/{ban}/revoke', 'Craftfall\BanController@revoke')->name('bans.revoke');
    });

    // External Stuff
    Route::get('/template-generator', 'External\TemplateGeneratorController@addonPack')->name('external.template_generator');
    Route::get('/template-generator/download', 'External\TemplateGeneratorController@generateAddonPack')->name('external.template_generator.download');
});
