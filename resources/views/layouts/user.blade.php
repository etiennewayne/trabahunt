<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>



    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">
        @auth
            <user-navbar prop-user='@json(auth()->user())'></user-navbar>
        @else
            <user-navbar prop-user=''></user-navbar>
        @endauth

        <div>
            @yield('content')
        </div>

        <footer-section></footer-section>


    </div>
</body>
</html>
