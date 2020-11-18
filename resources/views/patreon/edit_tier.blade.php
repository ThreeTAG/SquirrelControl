@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $tier->name !!}</h3>

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

                        <form action="{!! route('patreon.tier.update', ['tier' => $tier->id]) !!}"
                              method="POST">
                            @csrf

                            <label for="accessoires">Accessoires:</label>
                            <multi-select
                                id="accessoires"
                                name="accessoires[]"
                                :options="{{$allAccessoires}}"
                                :value="{{$tierAccessoires}}"
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
