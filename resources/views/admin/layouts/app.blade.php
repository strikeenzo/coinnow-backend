<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Univ Dev">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets') }}/img/brand/favicon.png" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/otrixweb.css?v=1.2.0" type="text/css">
    <link rel="stylesheet" href="{{ asset('custom') }}/css/custom.css" type="text/css">
    <style>
        .global-alert-message {
            margin-left: 10px;
            width: 100%;
            margin-bottom: 0px !important;
        }
    </style>
    @stack('styles')
</head>

<body>
@auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth
<!-- Sidenav -->
@include('admin.layouts.sidebar')
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
@include('admin.layouts.topnavbar')

    <!-- Header -->
    <!-- Header -->
@yield('content')
</div>
<!-- Argon Scripts -->

<script src="{{ asset('assets') }}/vendor/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('assets') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const datePickerFormat = "{{ config('constant.date_format')['date_format_js'] }}"

    $('ul.navbar-nav li.nav-item div ul li').each(function(ind,val){
            if($(this).find('a').attr('href') == $(location).attr('href'))
            {
                $(this).parents('div.collapse').addClass('show');
                $(this).parents('div.collapse').siblings('a.nav-link').addClass('active');
                $(this).parents('div.collapse').siblings('a.nav-link').attr('aria-expanded',true);
                $(this).parents('ul.nav').siblings('a.nav-link').addClass('active');
                $(this).parents('ul.nav').siblings('a.nav-link').attr('aria-expanded',true);
                $(this).addClass('current_sidebar_link');
                // $(this).parent('a.nav-link').addClass('active');
            }
    })
</script>
@stack('js')
<!-- Core -->
<script src="{{ asset('assets') }}/vendor/js-cookie/js.cookie.js"></script>
<script src="{{ asset('assets') }}/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
<!-- Argon JS -->
<script src="{{ asset('assets') }}/js/otrixweb.js?v=1.2.0"></script>
<script src="{{ asset('custom') }}/custom.js"></script>

</body>

</html>
