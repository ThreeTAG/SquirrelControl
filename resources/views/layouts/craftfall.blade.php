@extends('layouts.app')

@section('navbar-brand')
    <a class="navbar-brand" href="{{ url('/craftfall') }}">
        Craftfall
    </a>
@endsection

@section('navbar-style', 'background-color: #03a9f4 !important')

@section('navbar-switch-button')
    <li class="nav-item">
        <a class="nav-link" href="/"><i class="fa fa-exchange"></i> SquirrelControl</a>
    </li>
@endsection

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
                        @can([\App\Permission::WEB_CRAFTFALL_PLAYERS_VIEW, \App\Permission::WEB_CRAFTFALL_PLAYERS_MANAGE_AUTHORIZATION])
                            <a class="dropdown-item" href="{!! route('craftfall.players.index') !!}">Players</a>
                        @endcan
                        @can(\App\Permission::WEB_CRAFTFALL_ROLES_MANAGE)
                            <a class="dropdown-item" href="{!! route('craftfall.roles.index') !!}">Roles</a>
                        @endcan
                            @can(\App\Permission::WEB_CRAFTFALL_BANS_VIEW)
                            <a class="dropdown-item" href="{!! route('craftfall.bans.index') !!}">Bans</a>
                            @endcan
                    </div>
                </li>
            @endif

        @endif
    </ul>
@endsection
