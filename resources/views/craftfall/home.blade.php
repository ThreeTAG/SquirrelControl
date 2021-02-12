@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($ping)
                            <h3>{!! $ping['description']['text'] !!}<br></h3><br>

                            Spieler: {!! $ping['players']['online'] . '/' . $ping['players']['max'] !!}

                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {!! $ping['players']['online'] / $ping['players']['max'] * 100 !!}%;"
                                     aria-valuenow="{!! $ping['players']['online'] !!}" aria-valuemin="0"></div>
                            </div>

                            <br>

                            <p>
                                <a class="btn btn-primary" data-toggle="collapse" href="#playerList" role="button"
                                   aria-expanded="false" aria-controls="playerList">
                                    Show players
                                </a>
                            </p>

                            <div class="collapse" id="playerList">
                                @if(isset($ping['players']['sample']))
                                    @foreach($ping['players']['sample'] as $player)
                                        <a href="">{!! $player['name'] !!}</a><br>
                                    @endforeach
                                @endif
                            </div>

                        @else
                            Server offline :/
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
