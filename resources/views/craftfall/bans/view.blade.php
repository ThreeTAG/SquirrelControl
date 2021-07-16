@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">{!! $ban->player->name !!} <span
                            class="badge badge-{!! $ban->revokedBy ? 'success' : 'secondary' !!}">{!! $ban->revokedBy ? 'Unbanned' : 'Banned' !!}</span>
                    </h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <label>Banned by:</label><br>
                        {!! $ban->createdBy->name !!}

                        <hr>

                        <label>Expires:</label><br>
                        {!! $ban->until ? \Carbon\Carbon::parse($ban->until)->format('d/m/Y H:i') : 'Permanent' !!}

                        <hr>

                        <label>Reason:</label><br>
                        {!! $ban->reason !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
