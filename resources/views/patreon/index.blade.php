@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Patreon</div>

                    <div class="card-body">

                        @if(\Illuminate\Support\Facades\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Illuminate\Support\Facades\Session::get('success') !!}
                            </div>
                        @endif

                        @if(\Illuminate\Support\Facades\Session::has('error'))
                            <div class="alert alert-danger">
                                {!! \Illuminate\Support\Facades\Session::get('error') !!}
                            </div>
                        @endif

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="nav-item"><a class="nav-link active" href="#patrons"
                                                                        aria-controls="patrons" role="tab"
                                                                        data-toggle="tab">Patrons</a></li>
                            <li role="presentation" class="nav-item"><a class="nav-link" href="#tiers"
                                                                        aria-controls="tiers" role="tab"
                                                                        data-toggle="tab">Patron Tiers</a></li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="patrons">
                                {!! $patrons->links() !!}
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Tier</th>
                                        <th>Minecraft Player</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($patrons as $patron)
                                        <tr>
                                            <td>{!! $patron->name !!}</td>
                                            <td>{!! $patron->email !!}</td>
                                            <td>{!! $patron->tier ? $patron->tier->name : '/' !!}</td>
                                            <td>
                                                <form
                                                    action="{!! route('patreon.patron.update', ['patron' => $patron->id]) !!}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="text" name="player_name"
                                                           class="form-control alert alert-{!! $patron->player ? 'success' : 'danger' !!}"
                                                           value="{!! $patron->player ? $patron->player->name : '' !!}"
                                                           placeholder="Player Name/UUID...">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tiers">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($patronTiers as $tier)
                                        <tr>
                                            <td>{!! $tier->name !!}</td>
                                            <td><a href="{!! route('patreon.tier.edit', ['tier' => $tier->id]) !!}"
                                                   class="btn btn-primary">Manage</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
