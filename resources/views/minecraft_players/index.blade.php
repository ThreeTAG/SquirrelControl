@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>

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

                        <form action="{!! route('minecraft-players.store') !!}" method="POST">
                            @csrf

                            <label for="name">Add by Name/UUID:</label>
                            <input type="text" class="form-control" id="name" name="name">

                            <button class="btn btn-success" type="submit">Save</button>

                        </form>

                        <hr>

                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>UUID</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($players as $player)
                                <tr>
                                    <td>{!! $player->name !!}</td>
                                    <td>{!! $player->uuid !!}</td>
                                    <td><a class="btn btn-primary" href="{!! route('minecraft-players.edit', ['player' => $player->id]) !!}">Manage</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
