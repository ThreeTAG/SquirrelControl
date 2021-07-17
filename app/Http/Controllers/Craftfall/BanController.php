<?php

namespace App\Http\Controllers\Craftfall;

use App\Ban;
use App\Http\Controllers\Controller;
use App\Http\Helpers\MinecraftPlayerHelper;
use App\Permission;
use App\Rules\ValidMinecraftPlayerRule;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Laravelista\Comments\Comment;
use Thedudeguy\Rcon;

class BanController extends Controller
{
    /**
     * BanController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionMiddleware(Permission::WEB_CRAFTFALL_BANS_VIEW);
        $this->permissionMiddleware(Permission::WEB_CRAFTFALL_BANS_CREATE)->only(['create', 'store']);
        $this->permissionMiddleware(Permission::WEB_CRAFTFALL_BANS_REVOKE)->only(['revoke']);
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

    public function postComment(Ban $ban)
    {
        $comment = new Comment();
        $comment->commenter()->associate(auth()->user());
        $comment->commentable()->associate($ban);
        $comment->comment = request('comment');
        $comment->save();

        return view('craftfall.bans.comment', compact('comment'));
    }

    public function create($name = null)
    {
        try {
            $player = MinecraftPlayerHelper::getMinecraftPlayer($name);
        } catch (\Exception $e) {
            $player = null;
        }

        return view('craftfall.bans.create', compact('player'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'player' => ['required', new ValidMinecraftPlayerRule()],
            'reason' => 'required|string',
            'expiryType' => 'required|integer',
            'expiry_until' => [Rule::requiredIf(intval($request->get('expiryType')) === 2)],
            'expiry_for' => [Rule::requiredIf(intval($request->get('expiryType')) === 3)],
        ]);

        try {
            $player = MinecraftPlayerHelper::getMinecraftPlayer($request->get('player'));
        } catch (\Exception $e) {
            abort(404);
        }

        $expiryType = intval($request->get('expiryType'));
        $until = null;
        if ($expiryType === 2) {
            $until = Carbon::parse($request->get('expiry_until'));
        } else if ($expiryType === 3) {
            $until = Carbon::createFromTimestamp(strtotime($request->get('expiry_for')));
        }

        $ban = Ban::create([
            'player_id' => $player->id,
            'created_by_id' => auth()->user()->id,
            'reason' => $request->get('reason'),
            'until' => $until,
        ]);

        $rcon = new Rcon(env('MINECRAFT_SERVER_IP'), env('MINECRAFT_SERVER_RCON_PORT'), env('MINECRAFT_SERVER_RCON_PASSWORD'), 3);

        if ($rcon->connect()) {
            $rcon->sendCommand('ban kick ' . $player->name);
        }

        return redirect()->route('craftfall.bans.view', compact('ban'));
    }

    public function revoke(Ban $ban)
    {
        if ($ban->revokedBy) {
            return redirect()->route('craftfall.bans.view', compact('ban'));
        }

        $now = Carbon::now();
        $ban->update([
            'revoked_by_id' => auth()->user()->id,
            'revoked_at' => $now,
        ]);

        $comment = new Comment();
        $comment->commenter()->associate(auth()->user());
        $comment->commentable()->associate($ban);
        $comment->comment = request('reason');
        $comment->setCreatedAt($now);
        $comment->save();

        return redirect()->route('craftfall.bans.view', compact('ban'));
    }
}
