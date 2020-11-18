@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $user->name !!}</h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <form action="{!! route('users.update', ['user' => $user->id]) !!}" method="POST">
                            @csrf
                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name"
                                           placeholder="Name" type="text" value="{!! $user->name !!}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="email">E-Mail</label>
                                    <input class="form-control" id="email"
                                           placeholder="E-Mail" type="email" value="{!! $user->email !!}">
                                </div>
                            </div>

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

                            <hr>

                            <button class="btn btn-success" type="submit">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
