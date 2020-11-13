@foreach($players as $player)
    <tr>
        <td>{!! $player->name !!}</td>
        <td>{!! $player->uuid !!}</td>
        <td>{!! $player->patron && $player->patron->tier ? $player->patron->tier->name : '-' !!}</td>
        <td><a class="btn btn-primary" href="{!! route('minecraft-players.edit', ['player' => $player->id]) !!}">Manage</a></td>
    </tr>
@endforeach
