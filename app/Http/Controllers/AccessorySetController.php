<?php

namespace App\Http\Controllers;

use App\Accessory;
use App\AccessorySet;
use App\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AccessorySetController extends Controller
{
    /**
     * AccessoireController constructor.
     */
    public function __construct()
    {
        $this->permissionMiddleware(Permission::WEB_ACCESSOIRES_MANAGE);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $sets = AccessorySet::query()->paginate(20);

        return view('accessory_sets.index', compact('sets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        AccessorySet::query()->create(['name' => $request->get('name')]);
        Session::flash('success', 'Accessory Set added!');

        return redirect()->route('accessories.sets.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccessorySet $set
     * @return Application|Factory|View
     */
    public function edit(AccessorySet $set): Factory|View|Application
    {
        // map function for the vue-treeselect
        $mapForTreeSelect = function ($model) {
            return [
                'id' => $model->id,
                'label' => $model->name
            ];
        };

        $allAccessories = Accessory::all()->map($mapForTreeSelect);
        $setAccessories = $set->accessories->map($mapForTreeSelect)->pluck('id');

        return view('accessory_sets.edit', compact('set', 'allAccessories', 'setAccessories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AccessorySet $set
     * @return RedirectResponse
     */
    public function update(Request $request, AccessorySet $set): RedirectResponse
    {
        $set->accessories()->sync($request->get('accessories'));
        $set->update(['name' => $request->get('name'), 'is_reward' => $request->get('is_reward', false)]);

        Session::flash('success', 'Accessory Set ' . $set->name . ' updated!');

        return redirect()->route('accessories.sets.index');
    }
}
