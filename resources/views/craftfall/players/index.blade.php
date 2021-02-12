@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Players</h3>

                    <div class="card-body">

                        @include('partials.error-success-info')

                        <input type="text" class="form-control" id="player-search" placeholder="Search...">

                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>UUID</th>
                                <th>Last Join</th>
                                @if(auth()->user()->hasPermissionTo('craftfall.players.manage.authorization'))
                                    <th></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="table-content">
                            @include('craftfall.players.table_rows', compact('players'))
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#player-search').on('input propertychange', function () {
                $.ajax({
                    method: "GET",
                    url: "/craftfall/players/search/" + $(this).val(),
                }).done(function (msg) {
                    $('#table-content').html(msg);
                });
            });
        });
    </script>
@endsection
