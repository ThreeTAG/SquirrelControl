<?php

namespace App\Http\Controllers;

use App\Accessoire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccessoireController extends Controller
{
    /**
     * AccessoireController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:accessoires.manage');
    }

    public function index()
    {
        $accessoires = Accessoire::paginate(20);

        return view('accessoires.index', compact('accessoires'));
    }

    public function store(Request $request)
    {
        $accessoire = Accessoire::whereName($request->get('name'))->first();

        if ($accessoire) {
            Session::flash('error', 'An accessoire with that name already exists!');
        } else {
            Accessoire::create([
                'name' => $request->get('name'),
            ]);
            Session::flash('success', 'Accessoire added!');
        }

        return redirect()->back();
    }

    public function destroy(Accessoire $accessoire)
    {
        try {
            $accessoire->delete();
            Session::flash('success', 'Accessoire deleted!');
        } catch (\Exception $e) {
            Session::flash('error', 'Whoops! Something went wrong!');
        }

        return redirect()->back();
    }

}
