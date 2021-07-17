@extends('layouts.craftfall')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light">
                    <h3 class="card-header">New Ban</h3>

                    <div class="card-body">

                        @include('partials.errors')

                        <form action="{!! route('craftfall.bans.store') !!}" method="POST">
                            @csrf

                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="player">Player</label>
                                    <input class="form-control" id="player" name="player"
                                           placeholder="Player" type="text" value="{!! old('player') !!}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="floating-label textfield-box">
                                    <label for="prefix">Reason</label>
                                    <input class="form-control" id="reason" name="reason"
                                           placeholder="Reason" type="text" value="{!! old('reason') !!}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="expiry">Expiry</label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="expiryType" id="expiryRadio1"
                                           value="1" {!! intval(old('expiryType', 1)) === 1 ? 'checked' : '' !!}>
                                    <label class="form-check-label" for="expiryRadio1">
                                        Permanent
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="expiryType" id="expiryRadio2"
                                           value="2" {!! intval(old('expiryType', 1)) === 2 ? 'checked' : '' !!}>
                                    <label class="form-check-label" for="expiryRadio2">
                                        Until...
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="expiryType" id="expiryRadio3"
                                           value="3" {!! intval(old('expiryType', 1)) === 3 ? 'checked' : '' !!}>
                                    <label class="form-check-label" for="expiryRadio3">
                                        For...
                                    </label>
                                </div>

                                <input style="{!! intval(old('expiryType', 1)) === 2 ? '' : 'display: none' !!}" class="form-control expiry_option" id="expiry_until" name="expiry_until"
                                       placeholder="Until..." type="datetime-local"
                                       value="{!! old('expiry_until') !!}">

                                <input style="{!! intval(old('expiryType', 1)) === 3 ? '' : 'display: none' !!}" class="form-control expiry_option" id="expiry_for" name="expiry_for"
                                       placeholder="For..." type="text" value="{!! old('expiry_for') !!}">
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

@section('script')
    <script>
        $(this).ready(function () {
            $('input[type=radio][name=expiryType]').change(function () {
                $('.expiry_option').hide();

                if(parseInt(this.value) === 2) {
                    $('#expiry_until').show();
                } else if(parseInt(this.value) === 3) {
                    $('#expiry_for').show();
                }
            });
        });
    </script>
@endsection
