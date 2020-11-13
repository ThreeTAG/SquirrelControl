@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">

                        @include('partials.error-success-info')

                        <form action="{!! route('minecraft-players.store') !!}" method="POST">
                            @csrf

                            <label for="name">Add by Name/UUID:</label>
                            <input type="text" class="form-control" id="name" name="name">

                            <button class="btn btn-success" type="submit">Save</button>

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
