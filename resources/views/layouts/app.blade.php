<!DOCTYPE html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>

    @vite(['resources/css/app.css'])
    @yield('style')

</head>
<body class="sb-nav-fixed">
@include('layouts.includes.topNavbar')
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        @include('layouts.includes.adminMenu')
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                @include('layouts.includes.breadcrumb')
                @include('layouts.includes.success')
                @yield('mainContent')
            </div>
        </main>
        @include('layouts.includes.footer')
    </div>
</div>
@vite(['resources/js/app.js'])

@yield('script')
</body>
</html>
