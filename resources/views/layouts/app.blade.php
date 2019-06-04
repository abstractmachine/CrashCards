<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
<!--     <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> -->

</head>
<body>
    <div id="app">
        <nav id="main-nav">
            <div class="">

                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <span id="logo">🃏</span>
                    <span class="text-uppercase font-weight-bold ml-3">Crash Card Club</span>
                </a>

            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>


    {{-- <script src="/js/app.js"></script>  --}}
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
