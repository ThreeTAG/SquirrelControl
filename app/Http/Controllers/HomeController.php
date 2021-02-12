<?php

namespace App\Http\Controllers;

use App\Http\Helpers\MojangAPI;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the craftfall dashboard.
     *
     * @return Renderable
     */
    public function craftfall()
    {
        $ping = MojangAPI::ping('94.130.23.197:25564');
        return view('craftfall.home', compact('ping'));
    }
}
