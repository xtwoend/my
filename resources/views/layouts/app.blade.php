<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
    <body class="page-profile">
        @include('layouts.header')
        <div class="content content-fixed" id="app">
            <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
                @yield('main')
            </div>
        </div>
        <!-- Scripts -->
        <script src="{{ mix('js/manifest.js') }}"></script>
        <script src="{{ mix('js/vendor.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>
        <script type="text/javascript">
            feather.replace();
        </script>
        @yield('js')
    </body>
</html>
