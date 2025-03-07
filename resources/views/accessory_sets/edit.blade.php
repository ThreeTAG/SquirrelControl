@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $set->name !!}</h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <form action="{!! route('accessories.sets.update', ['set' => $set->id]) !!}"
                              method="POST">
                            @csrf

                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name" name="name"
                                           placeholder="Name" type="text" value="{!! $set->name !!}">
                                </div>
                            </div>

                            <div class="">
                                <label for="is_reward">Is Reward</label>
                                <input class="form-control" id="is_reward" name="is_reward" value="1"
                                       type="checkbox" @if($set->is_reward) checked @endif>
                            </div>

                            <div class="form-group">
                                <label for="accessoires">Accessories:</label>
                                <multi-select
                                    id="accessories"
                                    name="accessories[]"
                                    :options="{{$allAccessories}}"
                                    :value="{{$setAccessories}}"
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
