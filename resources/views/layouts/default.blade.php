@extends('layouts.app')

@section('navbar-brand')
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'SquirrelControl') }}
    </a>
@endsection

@section('navbar-switch-button')
    <li class="nav-item">
        <a class="nav-link" href="/craftfall"><i class="fa fa-exchange"></i> Craftfall</a>
    </li>
@endsection

@section('navbar')
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
        @if(!auth()->guest())

            @if(auth()->user()->checkPermissionTo('users.manage') || auth()->user()->checkPermissionTo('roles.manage'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Administration
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(auth()->user()->checkPermissionTo('users.manage'))
                            <a class="dropdown-item" href="{!! route('users.index') !!}">Users</a>
                        @endif
                        @if(auth()->user()->checkPermissionTo('roles.manage'))
                            <a class="dropdown-item" href="{!! route('roles.index') !!}">Roles</a>
                        @endif
                    </div>
                </li>
            @endif

            @if(auth()->user()->checkPermissionTo('minecraft_players.manage') || auth()->user()->checkPermissionTo('patreon.manage'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Minecraft Players
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(auth()->user()->checkPermissionTo('minecraft_players.manage'))
                            <a class="dropdown-item" href="{!! route('minecraft-players.index') !!}">Players</a>
                        @endif
                        @if(auth()->user()->checkPermissionTo('patreon.manage'))
                            <a class="dropdown-item" href="{!! route('patreon.index') !!}">Patreon</a>
                        @endif
                    </div>
                </li>
            @endif

            @if(auth()->user()->checkPermissionTo('accessoires.manage'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Accessoires
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{!! route('accessoires.index') !!}">Accessoires</a>
                        <a class="dropdown-item" href="{!! route('accessoires.sets.index') !!}">Accessoire Sets</a>
                    </div>
                </li>
            @endif

        @endif
    </ul>
@endsection
