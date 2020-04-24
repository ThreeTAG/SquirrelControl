<?php

namespace App\Http\Controllers;

use App\Accessoire;
use App\Http\Helpers\MojangAPI;
use App\MinecraftPlayer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class MinecraftPlayerController extends Controller
{
    /**
     * MinecraftPlayerController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:minecraft_players.manage');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $players = MinecraftPlayer::all();

        return view('minecraft_players.index', compact('players'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $name = $request->get('name');

        $uuid = MojangAPI::getUuid($name);

        if ($uuid) {
            MinecraftPlayer::create([
                'name' => MojangAPI::getUsername($uuid),
                'uuid' => MojangAPI::formatUuid($uuid),
            ]);

            Session::flash('success', 'User added!');
        } else {
            Session::flash('error', 'This user does not exist!');
        }

        return redirect()->route('minecraft-players.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
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

        $allAccessoires = Accessoire::all()->map($mapForTreeSelect);
        $playerAccessoires = $player->accessoires->map($mapForTreeSelect)->pluck('id');

        return view('minecraft_players.edit', compact('player', 'allAccessoires', 'playerAccessoires'));
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
        $player->accessoires()->sync($request->get('accessoires'));

        return redirect()->route('minecraft-players.index');
    }
}
