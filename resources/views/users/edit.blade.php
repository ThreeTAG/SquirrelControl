@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{!! $user->name !!}</div>

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

                        <form action="{!! route('users.update', ['user' => $user->id]) !!}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="{!! $user->name !!}">
                            </div>

                            <div class="form-group">
                                <label for="email">E-Mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="{!! $user->email !!}">
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
