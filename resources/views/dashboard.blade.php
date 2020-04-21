@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <div class="card card-chart">
        <div class="card-header ">
            Hi
        </div>
        <div class="card-body">
            <iframe src="https://www.cfwidget.com/minecraft/mc-mods/threecore" width="100%" style="border: none;"></iframe>
            <iframe src="https://www.cfwidget.com/minecraft/mc-mods/pymtech" width="100%" style="border: none;"></iframe>
        </div>
    </div>
@endsection
