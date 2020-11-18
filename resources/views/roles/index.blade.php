@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Roles</h3>

                    <div class="card-body">

                        @include('partials.error-success-info')

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Users</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{!! $role->name !!}</td>
                                    <td>{!! $role->users->count() !!}</td>
                                    <td><a class="btn btn-primary" href="{!! route('roles.edit', ['role' => $role->id]) !!}">Manage</a></td>
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
