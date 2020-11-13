@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{!! $role->name !!}</div>

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

                        <form action="{!! route('roles.update', ['role' => $role->id]) !!}" method="POST">
                            @csrf

                            <label for="permissions">Permissions:</label>
                            <multi-select
                                id="permissions"
                                name="permissions[]"
                                :options="{{$allPermissions}}"
                                :value="{{$rolePermissions}}"
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
