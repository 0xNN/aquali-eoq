<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aquali') }}</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images') }}/aquali.jpg" />
    <link href="{{ asset('src') }}/assets/css/styles.min.css" rel="stylesheet">
    @yield('css')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.header')
            <!--  Header End -->
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('src') }}/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('src') }}/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('src') }}/assets/js/sidebarmenu.js"></script>
    <script src="{{ asset('src') }}/assets/js/app.min.js"></script>
    <script src="{{ asset('src') }}/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="{{ asset('src') }}/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="{{ asset('src') }}/assets/js/dashboard.js"></script>
    @yield('js')
</body>

</html>
