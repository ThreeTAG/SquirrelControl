@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $player->name !!}</h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <form action="{!! route('craftfall.players.update', ['player' => $player->id]) !!}"
                              method="POST" enctype="multipart/form-data">
                            @csrf

                            <label for="money">Money:</label>
                            <input type="number" name="money" id="money" class="form-control"
                                   value="{!! $craftfallData->money !!}">

                            <hr>

                            <label for="roles">Roles:</label>
                            <multi-select
                                id="roles"
                                name="roles"
                                :options="{{$allRoles}}"
                                :value="{{$userRoles}}"
                            >
                            </multi-select>

                            <label for="permissions">Permissions:</label>
                            <multi-select
                                id="permissions"
                                name="permissions"
                                :options="{{$allPermissions}}"
                                :value="{{$userPermissions}}"
                            >
                            </multi-select>

                            <button class="btn btn-success" type="submit">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
