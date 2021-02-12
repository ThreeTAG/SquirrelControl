@foreach($players as $player)
    <tr>
        <td>{!! $player->name !!}</td>
        <td>{!! $player->uuid !!}</td>
        <td>{!! \Carbon\Carbon::parse($player->getOrCreateCraftfallData()->last_join)->format('d/m/Y H:i') !!}</td>
        @if(auth()->user()->hasPermissionTo('craftfall.players.manage.authorization'))
            <td><a class="btn btn-primary" href="{!! route('craftfall.players.edit', ['player' => $player->id]) !!}">Manage</a>
            </td>
        @endif
    </tr>
@endforeach

@if($players->count() <= 0)
    <tr>
        <td colspan="4">Nothing found!</td>
    </tr>
@endif
