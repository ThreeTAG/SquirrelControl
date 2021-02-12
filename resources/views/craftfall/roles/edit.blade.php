@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $role->name !!}</h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <form action="{!! route('craftfall.roles.update', ['role' => $role->id]) !!}" method="POST">
                            @csrf

                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name" name="name"
                                           placeholder="Name" type="text" value="{!! $role->name !!}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="prefix">Prefix</label>
                                    <input class="form-control" id="prefix" name="prefix"
                                           placeholder="Prefix" type="text" value="{{$data->prefix}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="permissions">Permissions:</label>
                                <multi-select
                                    id="permissions"
                                    name="permissions[]"
                                    class="form-control"
                                    :options="{{$allPermissions}}"
                                    :value="{{$rolePermissions}}"
                                >
                                </multi-select>
                            </div>

                            <hr>

                            <button class="btn btn-success" type="submit">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
