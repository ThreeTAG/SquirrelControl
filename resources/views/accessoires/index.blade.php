@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Accessoires</div>

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

                        <form action="{!! route('accessoires.store') !!}" method="POST">
                            @csrf

                            <label for="name">Add Accessoire:</label>
                            <input type="text" class="form-control" id="name" name="name">

                            <button class="btn btn-success" type="submit">Save</button>

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
