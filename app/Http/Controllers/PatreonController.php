<?php

namespace App\Http\Controllers;

use App\Accessory;
use App\Http\Helpers\MinecraftPlayerHelper;
use App\Http\Helpers\MojangAPI;
use App\MinecraftPlayer;
use App\Patron;
use App\PatronTier;
use App\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PatreonController extends Controller
{
    /**
     * MinecraftPlayerController constructor.
     */
    public function __construct()
    {
        $this->permissionMiddleware(Permission::WEB_PATREON_MANAGE);
    }

    public function index()
    {
        $patrons = Patron::paginate(20);
        $patronTiers = PatronTier::all();

        return view('patreon.index', compact('patrons', 'patronTiers'));
    }

    public function updatePatronPlayer(Request $request, Patron $patron)
    {
        $name = $request->get('player_name');

        try {
            $player = MinecraftPlayerHelper::getMinecraftPlayer($name);
            $patron->player_id = $player->id;
            $patron->save();
            Session::flash('success', 'Minecraft Player linked!');
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('patreon.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PatronTier $tier
     * @return Application|Factory|View
     */
    public function editTier(PatronTier $tier)
    {
        // map function for the vue-treeselect
        $mapForTreeSelect = function ($model) {
            return [
                'id' => $model->id,
                'label' => $model->name
            ];
        };

        $allAccessoires = Accessory::all()->map($mapForTreeSelect);
        $tierAccessoires = $tier->accessoires->map($mapForTreeSelect)->pluck('id');

        return view('patreon.edit_tier', compact('tier', 'allAccessoires', 'tierAccessoires'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PatronTier $tier
     * @return RedirectResponse
     */
    public function updateTier(Request $request, PatronTier $tier)
    {
        $tier->accessoires()->sync($request->get('accessoires'));

        return redirect()->route('patreon.index');
    }

}
