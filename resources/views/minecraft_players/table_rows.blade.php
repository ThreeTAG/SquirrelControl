@foreach($players as $player)
    <tr>
        <td>{!! $player->name !!}</td>
        <td>{!! $player->uuid !!}</td>
        <td>{!! $player->patron && $player->patron->tier ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' !!}</td>
        <td><a class="btn btn-primary" href="{!! route('minecraft-players.edit', ['player' => $player->id]) !!}">Manage</a></td>
    </tr>
@endforeach

@if($players->count() <= 0)
    <tr>
        <td colspan="4">Nothing found!</td>
    </tr>
@endif
