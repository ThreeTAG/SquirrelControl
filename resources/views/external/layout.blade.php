<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="initial-scale=1, shrink-to-fit=no, width=device-width" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <style>
        .dropdown-toggle::after {
            content: '';
        }
    </style>

    @yield('css')
</head>
<body class="">
<div id="app" class="app container mx-auto">
    <div class="flex flex-row flex-wrap py-4">
        <main role="main" class="w-full sm:w-2/3 md:w-3/4 pt-1 px-2">
            @yield('content')
        </main>
    </div>
</div>
</body>

<div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('script')
</div>

</html>
