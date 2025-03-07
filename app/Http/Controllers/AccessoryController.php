<?php

namespace App\Http\Controllers;

use App\Accessory;
use App\Permission;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccessoryController extends Controller
{
    /**
     * AccessoireController constructor.
     */
    public function __construct()
    {
        $this->permissionMiddleware(Permission::WEB_ACCESSOIRES_MANAGE);
    }

    public function index(): Factory|View|Application
    {
        $accessories = Accessory::query()->paginate(20);

        return view('accessories.index', compact('accessories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $i = 0;
        foreach (explode(',', $request->get('name')) as $accessoire) {
            if ($accessoire && !Accessory::whereName($accessoire)->exists()) {
                Accessory::query()->create([
                    'name' => $accessoire,
                ]);
                $i++;
            }
        }

        Session::flash('success', $i . ' accessories added!');

        return redirect()->back();
    }

    public function destroy(Accessory $accessory): RedirectResponse
    {
        try {
            $accessory->delete();
            Session::flash('success', 'Accessory deleted!');
        } catch (Exception $e) {
            Session::flash('error', 'Whoops! Something went wrong!');
        }

        return redirect()->back();
    }

}
