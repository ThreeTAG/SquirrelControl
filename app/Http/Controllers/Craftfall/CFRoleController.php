<?php

namespace App\Http\Controllers\Craftfall;

use App\CraftfallData;
use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CFRoleController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:craftfall.roles.manage');
        $this->permissionMiddleware(Permission::WEB_CRAFTFALL_ROLES_MANAGE);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $roles = Role::where('guard_name', 'minecraft')->get()->map(function ($role) {
            return [
                'name' => $role->name,
                'id' => $role->id,
                'players' => DB::table('model_has_roles')->where('model_type', CraftfallData::class)->where('role_id', $role->id)->count(),
            ];
        });

        return view('craftfall.roles.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $name = $request->get('name');

        if (Role::query()->where('name', $name)->where('guard_name', 'minecraft')->exists()) {
            Session::flash('error', 'Role with that name already exists!');
        } else {
            Role::create([
                'name' => $name,
                'guard_name' => 'minecraft',
            ])->craftfallData()->create();
            Session::flash('success', 'Role added!');
        }

        return redirect()->route('craftfall.roles.index');
    }

    /**
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {
        // map function for the vue-treeselect
        $mapForTreeSelect = function ($model) {
            return [
                'id' => $model->id,
                'label' => $model->name
            ];
        };

        $allPermissions = Permission::where('guard_name', 'minecraft')->get()->map($mapForTreeSelect);

        $rolePermissions = $role->permissions->map($mapForTreeSelect)->pluck('id');

        $data = $role->craftfallData;

        if (!$data) {
            $data = $role->craftfallData()->create();
        }

        return view('craftfall.roles.edit', compact('role', 'allPermissions', 'rolePermissions', 'data'));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $role->permissions()->sync($request->get('permissions'));

        $data = $role->craftfallData;

        if ($data) {
            $data->update([
                'prefix' => json_decode(json_encode($request->get('prefix')), true),
            ]);
        } else {
            $role->craftfallData()->create([
                'prefix' => json_decode(json_encode($request->get('prefix')), true),
            ]);
        }

        return redirect()->route('craftfall.roles.index');
    }

}
