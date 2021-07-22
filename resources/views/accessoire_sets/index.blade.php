@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Accessoire Sets</h3>

                    <div class="card-body">

                       @include('partials.error-success-info')

                        <form action="{!! route('accessoires.sets.store') !!}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-5 mb-3 form-group">
                                    <div class="floating-label textfield-box">
                                        <label for="name">Add Accessoire Set</label>
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
