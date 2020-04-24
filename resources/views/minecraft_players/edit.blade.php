@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{!! $player->name !!}</div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{!! route('minecraft-players.update', ['player' => $player->id]) !!}"
                              method="POST">
                            @csrf

                            <label for="accessoires">Accessoires:</label>
                            <multi-select
                                id="accessoires"
                                name="accessoires[]"
                                :options="{{$allAccessoires}}"
                                :value="{{$playerAccessoires}}"
                            >
                            </multi-select>

                            <hr>

                            <button class="btn btn-success" type="submit">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
