<?php

namespace App\Http\Controllers\Craftfall;

use App\Http\Controllers\Controller;
use App\MinecraftPlayer;
use App\MoneyHistory;
use App\Permission;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class CFPlayerController extends Controller
{

    public function __construct()
    {
        $this->permissionMiddleware(Permission::WEB_CRAFTFALL_PLAYERS_VIEW);
        $this->permissionMiddleware(Permission::WEB_CRAFTFALL_PLAYERS_MANAGE_AUTHORIZATION)->only(['edit', 'update']);
    }

    public function index()
    {
        $players = MinecraftPlayer::query()->whereExists(function ($query) {
            $query->select('*')->from('craftfall_data')->whereColumn('craftfall_data.player_id', 'minecraft_players.id')->whereNotNull('last_join');
        })->paginate(30);

        return view('craftfall.players.index', compact('players'));
    }

    /**
     * @param $search
     * @return Application|Factory|View
     */
    public function search($search = null)
    {
        if($search) {
            $players = MinecraftPlayer::where('name', 'like', "%" . $search . "%")
                ->orWhere('uuid', 'like', "%" . $search . "%")->whereExists(function ($query) {
                    $query->select('*')->from('craftfall_data')->whereColumn('craftfall_data.player_id', 'minecraft_players.id')->whereNotNull('last_join');
                })->get();
        } else {
            $players = MinecraftPlayer::all();
        }

        return view('craftfall.players.table_rows', compact('players'));
    }

    /**
     * @param MinecraftPlayer $player
     * @return Application|Factory|View
     */
    public function edit(MinecraftPlayer $player)
    {
        // map function for the vue-treeselect
        $mapForTreeSelect = function ($model) {
            return [
                'id'    => $model->id,
                'label' => $model->name
            ];
        };

        $craftfallData = $player->getOrCreateCraftfallData();

        $allRoles = Role::where('guard_name', 'minecraft')->get()->map($mapForTreeSelect);
        $allPermissions = Permission::where('guard_name', 'minecraft')->get()->map($mapForTreeSelect);

        $userRoles = $craftfallData->roles->map($mapForTreeSelect)->pluck('id');
        $userPermissions = $craftfallData->permissions->map($mapForTreeSelect)->pluck('id');

        return view('craftfall.players.edit', compact('player', 'allRoles', 'allPermissions', 'userRoles', 'userPermissions', 'craftfallData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param MinecraftPlayer $player
     * @return RedirectResponse
     */
    public function update(Request $request, MinecraftPlayer $player)
    {
        $craftfallData = $player->getOrCreateCraftfallData();

        $craftfallData->roles()->sync($request->get('roles'));
        $craftfallData->permissions()->sync($request->get('permissions'));

        $money = $request->get('money');

        if($money !== $craftfallData->money) {
            $craftfallData->moneyHistories()->create([
                'new_amount' => $money,
                'difference' => $money - $craftfallData->money,
                'type' => MoneyHistory::TYPE_CHANGED_BY_STAFF,
                'description' => 'Changed by ' . auth()->user()->name,
            ]);
            $craftfallData->money = $money;
            $craftfallData->save();
        }

        return redirect()->route('craftfall.players.index');
    }
}
