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

                        @if(!$ban->revokedBy)
                            @can(\App\Permission::WEB_CRAFTFALL_BANS_REVOKE)
                                <hr>

                                <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                                        data-target="#revokeModal">
                                    Revoke Ban
                                </button>
                            @endcan
                        @endif
                    </div>
                </div>

                <br>
                <hr>

                <div id="comments">
                    @foreach($ban->comments as $comment)
                        @include('craftfall.bans.comment', compact('comment'))
                    @endforeach
                </div>

                <div class="card bg-light" style="width: 100%">
                    <h4 class="card-header">Post Comment <i class="fa fa-comment"></i></h4>
                    <div class="card-body">
                        <textarea id="comment-text-area" class="form-control" style="margin-bottom: 5px"></textarea>
                        <button id="post-comment-button" class="btn btn-primary pull-right">Send</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="revokeModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Revoke ban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{!! route('craftfall.bans.revoke', ['ban' => $ban->id]) !!}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <textarea class="form-control" name="reason" placeholder="Reason..." required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Revoke</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#post-comment-button').on('click', function () {
                $.ajax({
                    method: "POST",
                    url: "{!! route('craftfall.bans.comment', ['ban' => $ban->id]) !!}",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        comment: $('#comment-text-area').val(),
                    },
                    success: function (msg) {
                        $('#comment-text-area').val(null);
                        $('#comments').append(msg);
                    }
                });
            });
        });
    </script>
@endsection
