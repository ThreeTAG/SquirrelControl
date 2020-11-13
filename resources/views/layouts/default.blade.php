@extends('layouts.app')

@section('navbar')
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
        @if(!auth()->guest())

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Administration
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{!! route('users.index') !!}">Users</a>
                    <a class="dropdown-item" href="{!! route('roles.index') !!}">Roles</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Minecraft Players
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{!! route('minecraft-players.index') !!}">Players</a>
                    <a class="dropdown-item" href="{!! route('patreon.index') !!}">Patreon</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">
                    Accessoires
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{!! route('accessoires.index') !!}">Accessoires</a>
                    <a class="dropdown-item" href="{!! route('accessoires.sets.index') !!}">Accessoire Sets</a>
                </div>
            </li>

        @endif
    </ul>
@endsection
