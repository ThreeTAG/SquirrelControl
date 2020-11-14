<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:roles.manage');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
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

        $allPermissions = Permission::where('guard_name', 'web')->get()->map($mapForTreeSelect);

        $rolePermissions = $role->permissions->map($mapForTreeSelect)->pluck('id');

        return view('roles.edit', compact('role', 'allPermissions', 'rolePermissions'));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        $role->permissions()->sync($request->get('permissions'));

        return redirect()->route('roles.index');
    }

}
