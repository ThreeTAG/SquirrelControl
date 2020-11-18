@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $set->name !!}</h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <form action="{!! route('accessoires.sets.update', ['set' => $set->id]) !!}"
                              method="POST">
                            @csrf

                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name"
                                           placeholder="Name" type="text" value="{!! $set->name !!}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="accessoires">Accessoires:</label>
                                <multi-select
                                    id="accessoires"
                                    name="accessoires[]"
                                    :options="{{$allAccessoires}}"
                                    :value="{{$setAccessoires}}"
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
