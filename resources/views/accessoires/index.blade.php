@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Accessoires</h3>

                    <div class="card-body">

                        @include('partials.error-success-info')

                        <form action="{!! route('accessoires.store') !!}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-5 mb-3 form-group">
                                    <div class="floating-label textfield-box">
                                        <label for="name">Add Accessoire</label>
                                        <input class="form-control" id="name"
                                               placeholder="ID" type="text">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-success" type="submit">Add</button>
                                </div>
                            </div>

                        </form>

                        <hr>

                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($accessoires as $accessoire)
                                <tr>
                                    <td>{!! $accessoire->name !!}</td>
                                    <td>
                                        <form action="{!! route('accessoires.destroy', compact('accessoire')) !!}"
                                              method="POST">
                                            @csrf
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
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
