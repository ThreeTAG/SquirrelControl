<?php

namespace App\Http\Controllers;

use App\Accessoire;
use App\AccessoireSet;
use App\Http\Helpers\MinecraftPlayerHelper;
use App\MinecraftPlayer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AccessoireSetController extends Controller
{
    /**
     * AccessoireController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:accessoires.manage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $sets = AccessoireSet::query()->paginate(20);

        return view('accessoire_sets.index', compact('sets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        AccessoireSet::create(['name' => $request->get('name')]);
        Session::flash('success', 'Accessoire Set added!');

        return redirect()->route('accessoires.sets.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccessoireSet $set
     * @return Application|Factory|View
     */
    public function edit(AccessoireSet $set)
    {
        // map function for the vue-treeselect
        $mapForTreeSelect = function ($model) {
            return [
                'id' => $model->id,
                'label' => $model->name
            ];
        };

        $allAccessoires = Accessoire::all()->map($mapForTreeSelect);
        $setAccessoires = $set->accessoires->map($mapForTreeSelect)->pluck('id');

        return view('accessoire_sets.edit', compact('set', 'allAccessoires', 'setAccessoires'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AccessoireSet $set
     * @return RedirectResponse
     */
    public function update(Request $request, AccessoireSet $set)
    {
        $set->accessoires()->sync($request->get('accessoires'));
        $set->update(['name' => $request->get('name')]);

        Session::flash('success', 'Accessoire Set ' . $set->name . ' updated!');

        return redirect()->route('accessoires.sets.index');
    }
}
