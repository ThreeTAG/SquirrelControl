<?php

namespace App\Http\Controllers\Craftfall;

use App\Ban;
use App\Http\Controllers\Controller;
use App\MinecraftPlayer;
use App\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Query\Builder;
use Illuminate\View\View;

class BanController extends Controller
{
    /**
     * BanController constructor.
     */
    public function __construct()
    {
        $this->permissionMiddleware(Permission::WEB_CRAFTFALL_BANS_VIEW)->only('index');
    }

    protected function index()
    {
        $bans = Ban::paginate(30);

        return view('craftfall.bans.index', compact('bans'));
    }

    /**
     * @param $search
     * @return Application|Factory|View
     */
    public function search($search = null)
    {
        if ($search) {
            $bans = Ban::whereHas('player', function ($query) use ($search) {
                $query->where('name', 'like', "%" . $search . "%");
            })->get();
        } else {
            $bans = Ban::all();
        }

        return view('craftfall.bans.table_rows', compact('bans'));
    }

    public function view(Ban $ban)
    {
        return view('craftfall.bans.view', compact('ban'));
    }
}
