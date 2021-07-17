@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @include('partials.errors')

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

                            @if(auth()->user()->hasRole('Admin'))
                                <form action="{!! route('craftfall.command') !!}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control" name="command" placeholder="Command">
                                    <button type="submit" class="btn btn-primary">Send Command</button>
                                </form>
                            @endif

                        @else
                            Server offline :/
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
