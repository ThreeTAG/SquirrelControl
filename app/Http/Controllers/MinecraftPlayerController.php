<?php

namespace App\Http\Controllers;

use App\Accessoire;
use App\AccessoireSet;
use App\Http\Helpers\MinecraftPlayerHelper;
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
        $players = MinecraftPlayer::query()->paginate(30);

        return view('minecraft_players.index', compact('players'));
    }

    /**
     * @param $search
     * @return Application|Factory|View
     */
    public function search($search = null)
    {
        if($search) {
            $players = MinecraftPlayer::where('name', 'like', "%" . $search . "%")
                ->orWhere('uuid', 'like', "%" . $search . "%")->get();
        } else {
            $players = MinecraftPlayer::all();
        }

        return view('minecraft_players.table_rows', compact('players'));
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

        try {
            MinecraftPlayerHelper::getMinecraftPlayer($name);
            Session::flash('success', 'Player added!');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
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
                'id' => $model->id,
                'label' => $model->name
            ];
        };
        $allAccessoires = Accessoire::all()->map($mapForTreeSelect);
        $playerAccessoires = $player->accessoires->map($mapForTreeSelect)->pluck('id');

        $allAccessoireSets = AccessoireSet::all()->map($mapForTreeSelect);
        $playerAccessoireSets = $player->accessoireSets->map($mapForTreeSelect)->pluck('id');

        return view('minecraft_players.edit', compact('player', 'allAccessoires', 'playerAccessoires', 'allAccessoireSets', 'playerAccessoireSets'));
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
        $player->accessoireSets()->sync($request->get('accessoire_sets'));

        $player->getOrCreateModSupporterData()->update([
            'mod_access' => $request->get('mod_access'),
        ]);

        if ($request->has('cloak_file') && $request->file('cloak_file')->isValid()) {
            $request->validate([
                'cloak_file' => 'mimes:png|max:1014',
            ]);
            $file = $request->file('cloak_file');
            self::prepareCloakImagesFolder();
            $file->store('', ['disk' => 'cloaks']);
            $player->getOrCreateModSupporterData()->update([
                'cloak_path' => $file->hashName(),
            ]);
        }

        Session::flash('success', 'Player ' . $player->name . ' updated!');

        return redirect()->route('minecraft-players.index');
    }

    public static function prepareCloakImagesFolder()
    {
        $folderPath = public_path('img/cloaks/');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        return $folderPath;
    }
}
