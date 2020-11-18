@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $player->name !!}</h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <form action="{!! route('minecraft-players.update', ['player' => $player->id]) !!}"
                              method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" {!! $player->getOrCreateModSupporterData()->mod_access ? 'checked' : '' !!} id="mod_access" name="mod_access">
                                <label class="form-check-label" for="mod_access">
                                    Mod Access
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="cloak_file">Supporter Cloak Image</label>
                                <input type="file" class="form-control-file" id="cloak_file">
                                @if($player->getOrCreateModSupporterData()->cloak_path)
                                    <br>
                                    <img
                                        src="{!! asset('img/cloaks/' . $player->getOrCreateModSupporterData()->cloak_path) !!}">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="accessoires">Accessoires:</label>
                                <multi-select
                                    id="accessoires"
                                    name="accessoires[]"
                                    :options="{{$allAccessoires}}"
                                    :value="{{$playerAccessoires}}"
                                >
                                </multi-select>
                            </div>

                            <div class="form-group">
                                <label for="accessoires">Accessoire Sets:</label>
                                <multi-select
                                    id="accessoire_sets"
                                    name="accessoire_sets[]"
                                    :options="{{$allAccessoireSets}}"
                                    :value="{{$playerAccessoireSets}}"
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
