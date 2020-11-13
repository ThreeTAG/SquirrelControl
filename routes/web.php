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

    Route::get('/patreon', 'PatreonController@index')->name('patreon.index');
    Route::get('/patreon/tier/{tier}', 'PatreonController@editTier')->name('patreon.tier.edit');
    Route::post('/patreon/tier/{tier}', 'PatreonController@updateTier')->name('patreon.tier.update');
    Route::post('/patreon/patron/{patron}', 'PatreonController@updatePatronPlayer')->name('patreon.patron.update');

    Route::get('/accessoires', 'AccessoireController@index')->name('accessoires.index');
    Route::post('/accessoires/add', 'AccessoireController@store')->name('accessoires.store');
    Route::post('/accessoires/{accessoire}/delete', 'AccessoireController@destroy')->name('accessoires.destroy');

    Route::get('/accessoires/sets', 'AccessoireSetController@index')->name('accessoires.sets.index');
    Route::post('/accessoires/sets/add', 'AccessoireSetController@store')->name('accessoires.sets.store');
    Route::get('/accessoires/sets/{set}', 'AccessoireSetController@edit')->name('accessoires.sets.edit');
    Route::post('/accessoires/sets/{set}', 'AccessoireSetController@update')->name('accessoires.sets.update');
});
