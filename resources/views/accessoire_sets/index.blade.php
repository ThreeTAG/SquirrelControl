@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">

                       @include('partials.error-success-info')

                        <form action="{!! route('accessoires.sets.store') !!}" method="POST">
                            @csrf

                            <label for="name">Add Accessoire Set:</label>
                            <input type="text" class="form-control" id="name" name="name">

                            <button class="btn btn-success" type="submit">Save</button>

                        </form>

                        <hr>

                        {!! $sets->links() !!}

                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Accessoires</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sets as $set)
                                <tr>
                                    <td>{!! $set->name !!}</td>
                                    <td>{!! $set->accessoires->count() !!}</td>
                                    <td><a class="btn btn-primary" href="{!! route('accessoires.sets.edit', ['set' => $set->id]) !!}">Manage</a></td>
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
