@extends('layouts.app')

@section('navbar')
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
        @if(!auth()->guest())

            @if(auth()->user()->checkPermissionTo('craftfall.players.view') || auth()->user()->checkPermissionTo('craftfall.players.manage.authorization') || auth()->user()->checkPermissionTo('craftfall.roles.manage'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Administration
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(auth()->user()->checkPermissionTo('craftfall.players.view') || auth()->user()->checkPermissionTo('craftfall.players.manage.authorization'))
                            <a class="dropdown-item" href="{!! route('craftfall.players.index') !!}">Players</a>
                        @endif
                        @if(auth()->user()->checkPermissionTo('craftfall.roles.manage'))
                            <a class="dropdown-item" href="{!! route('craftfall.roles.index') !!}">Roles</a>
                        @endif
                    </div>
                </li>
            @endif

        @endif
    </ul>
@endsection
