@extends('external.layout')

@section('content')
    <div>
        <claim-reward token="{{ $token }}"></claim-reward>
    </div>
@endsection
