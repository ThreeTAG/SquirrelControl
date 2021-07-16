@foreach($bans as $ban)
    <tr>
        <td>{!! $ban->player->name !!}</td>
        <td>{!! $ban->createdBy->name !!}</td>
        <td>{!! $ban->until ? \Carbon\Carbon::parse($ban->until)->format('d/m/Y H:i') : 'Permanent' !!}</td>
        <td><a class="btn btn-primary" href="{!! route('craftfall.bans.view', ['ban' => $ban->id]) !!}">View</a></td>
    </tr>
@endforeach

@if($bans->count() <= 0)
    <tr>
        <td colspan="4">Nothing found!</td>
    </tr>
@endif
