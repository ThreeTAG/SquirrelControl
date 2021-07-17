<?php

namespace App\Http\Controllers;

use App\Http\Helpers\MojangAPI;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Thedudeguy\Rcon;

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
    public function index(): Renderable
    {
        return view('home');
    }

    /**
     * Show the craftfall dashboard.
     *
     * @return Renderable
     */
    public function craftfall(): Renderable
    {
        $ping = MojangAPI::ping('94.130.23.197:25564');
        return view('craftfall.home', compact('ping'));
    }

    public function command()
    {
        $command = request('command');

        $rcon = new Rcon(env('MINECRAFT_SERVER_IP'), env('MINECRAFT_SERVER_RCON_PORT'), env('MINECRAFT_SERVER_RCON_PASSWORD'), 3);

        if ($rcon->connect()) {
            $rcon->sendCommand($command);
        }

        return redirect()->route('craftfall.home');
    }
}
