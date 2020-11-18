@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Users</h3>

                    <div class="card-body">
                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Roles</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{!! $user->name !!}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-secondary">{!! $role->name !!}</span>
                                        @endforeach
                                    </td>
                                    <td><a class="btn btn-primary" href="{!! route('users.edit', ['user' => $user->id]) !!}">Manage</a></td>
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
