@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Roles</h3>

                    <div class="card-body">

                        @include('partials.error-success-info')

                        <form action="{!! route('craftfall.roles.store') !!}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-5 mb-3 form-group">
                                    <div class="floating-label textfield-box">
                                        <label for="name">Add by Name</label>
                                        <input class="form-control" id="name" name="name"
                                               placeholder="Name" type="text">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-success" type="submit">Add</button>
                                </div>
                            </div>

                        </form>

                        <hr>

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
                                    <td>{!! $role['name'] !!}</td>
                                    <td>{!! $role['players'] !!}</td>
                                    <td><a class="btn btn-primary" href="{!! route('craftfall.roles.edit', ['role' => $role['id']]) !!}">Manage</a></td>
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
