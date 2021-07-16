@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">Bans</h3>

                    <div class="card-body">

                        @include('partials.error-success-info')

                        <input type="text" class="form-control" id="ban-search" placeholder="Search...">

                        <table class="table table-striped" id="userTable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Banned by</th>
                                <th>Expires at</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="table-content">
                            @include('craftfall.bans.table_rows', compact('bans'))
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
            $('#ban-search').on('input propertychange', function () {
                $.ajax({
                    method: "GET",
                    url: "/craftfall/bans/search/" + $(this).val(),
                }).done(function (msg) {
                    $('#table-content').html(msg);
                });
            });
        });
    </script>
@endsection
