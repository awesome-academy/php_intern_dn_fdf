<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Locale Session-->
    <meta name="locale" content="{{ session()->get('locale') }}">

    <!-- Locale Session-->
    <meta name="id_user" content="{{ Auth::guard('web')->user()->id ?? '' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/client/tiny-slider.css') }}" rel="stylesheet">

    <link href="{{ asset('css/client/alllib.css') }}" rel="stylesheet">
</head>

<body class="pr-0">
    <!-- Start header -->
    @include('layouts.header')
    <!-- End header -->

    <div class="content">
        @yield('content')
    </div>

    <!-- Start Footer -->
    @include('layouts.footer')
    <!-- End Footer -->

    @include('partials.login')
    @include('partials.register')
    @include('partials.forgot')
    @include('partials.cart')
    @include('partials.favorite')
    @include('partials.notify')
    @include('partials.toast-order-user')

    <a href="#" id="back-to-top" title="Back to top" style="display: none;"><i class="fas fa-plane"
            aria-hidden="true"></i></a>

    <script src="{{ asset('js/client/jquery.min.js') }}"></script>
    <script src="{{ asset('js/client/bootstrap.min.js') }}"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/client/alllib.js') }}"></script>
    <script src="{{ asset('js/client/tiny-slider.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('js/client/home.js') }}"></script>
    <script src="{{ asset('js/client/pusher.js') }}"></script>
</body>
</html>
