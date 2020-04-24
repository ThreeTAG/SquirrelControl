<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:users.manage');
    }


    /**
     * Display a listing of the users
     *
     * @param User $user
     * @return View
     */
    public function index(User $user)
    {
        return view('users.index', ['users' => $user->paginate(15)]);
    }

    /**
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        // map function for the vue-treeselect
        $mapForTreeSelect = function ($model) {
            return [
                'id'    => $model->id,
                'label' => $model->name
            ];
        };

        $allRoles = Role::all()->map($mapForTreeSelect);
        $allPermissions = Permission::all()->map($mapForTreeSelect);

        $userRoles = $user->roles->map($mapForTreeSelect)->pluck('id');
        $userPermissions = $user->permissions->map($mapForTreeSelect)->pluck('id');

        return view('users.edit', compact('user', 'allRoles', 'allPermissions', 'userRoles', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $user->update($request->all());

        $user->roles()->sync($request->get('roles'));
        $user->permissions()->sync($request->get('permissions'));

        return redirect()->route('users.index');
    }

}
