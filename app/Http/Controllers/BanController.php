<?php

namespace App\Http\Controllers;

use App\Permission;

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

    }
}
