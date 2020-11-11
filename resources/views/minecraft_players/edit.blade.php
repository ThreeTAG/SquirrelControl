@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{!! $player->name !!}</div>

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

                        <form action="{!! route('minecraft-players.update', ['player' => $player->id]) !!}"
                              method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="mod_access">Mod Access:</label>
                                <input type="checkbox" id="mod_access" name="mod_access"
                                       value="1" {!! $player->getOrCreateModSupporterData()->mod_access ? 'checked' : '' !!}>
                            </div>

                            <div class="form-group">
                                <label for="cloak_file">Supporter Cloak Image:</label>
                                <input type="file" id="cloak_file" name="cloak_file">
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

                            <hr>

                            <button class="btn btn-success" type="submit">Save</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
