@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Players</h3>

                    <div class="card-body">

                        @include('partials.error-success-info')

                        <form action="{!! route('minecraft-players.store') !!}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-5 mb-3 form-group">
                                    <div class="floating-label textfield-box">
                                        <label for="name">Add by Name/UUID</label>
                                        <input class="form-control" id="name" name="name"
                                               placeholder="Name/UUID" type="text">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <button class="btn btn-success" type="submit">Add</button>
                                </div>
                            </div>

                        </form>

                        <hr>

                        <input type="text" class="form-control" id="player-search" placeholder="Search...">

                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>UUID</th>
                                <th>Patron</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="table-content">
                            @include('minecraft_players.table_rows', compact('players'))
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
                    url: "/minecraft-players/search/" + $(this).val(),
                }).done(function (msg) {
                    $('#table-content').html(msg);
                });
            });
        });
    </script>
@endsection
