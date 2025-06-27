<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    {{-- <meta name="description" content="POS - Bootstrap Admin Template"> --}}
    {{-- <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template"> --}}
    {{-- <meta name="robots" content="noindex, nofollow"> --}}
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <!-- animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <!-- Main Wrapper -->
    @yield('master')
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <!-- Sweetalert 2 -->
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/theme-script.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>
