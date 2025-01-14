<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title != '' ?? 'Eureka by VEPAGOS' }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    @yield('before-css')
    {{-- theme css --}}
    <link id="gull-theme" rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/perfect-scrollbar.css') }}">
    {{-- page specific css --}}
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/toastr.css') }}">

    @yield('page-css')

    @livewireStyles
</head>

<body class="text-left">
    {{-- @php
        $layout = session('layout');
        @endphp --}}

    <!-- Pre Loader Strat  -->
    <div class='loadscreen' id="preloader">

        <div class="loader spinner-bubble spinner-bubble-primary">


        </div>
    </div>
    <!-- Pre Loader end  -->

    <!-- ============ Large Sidebar Layout start ============= -->

    <div class="app-admin-wrap layout-sidebar-large clearfix">
        @include('layouts.header-menu')

        <!-- ============ end of header menu ============= -->

        @include('layouts.sidebar')

        <!-- ============ end of left sidebar ============= -->

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="main-content">
                @yield('main-content')
            </div>

            @include('layouts.footer')
        </div>
        <!-- ============ Body content End ============= -->
    </div>
    <!--=============== End app-admin-wrap ================-->

    <!-- ============ Search UI Start ============= -->
    {{-- @include('layouts.search') --}}
    <!-- ============ Search UI End ============= -->

    @include('layouts.customizer')

    <!-- ============ Large Sidebar Layout End ============= -->

    {{-- common js --}}
    {{-- <script src="{{mix('assets/js/common-bundle-script.js')}}"></script> --}}

    {{-- page specific javascript --}}
    @yield('page-js')

    {{-- theme javascript --}}
    {{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="{{ asset('assets/js/sidebar.large.script.js') }}"></script>

    <script src="{{ asset('assets/js/customizer.script.js') }}"></script>

    {{-- laravel js --}}
    {{-- <script src="{{mix('assets/js/laravel/app.js')}}"></script> --}}

    @yield('bottom-js')
    @livewireScripts
</body>

<script src="{{ asset('assets/js/vendor/toastr.min.js') }}"></script>
<script id="__bs_script__">
    //<![CDATA[
    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.13'><\/script>"
        .replace("HOST", location.hostname));
    //]>
</script>

</html>
