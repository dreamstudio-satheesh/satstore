<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <title>SAT Sweets - Admin Panel</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('') }}/assets/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/bootstrap.min.css">

    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/animate.css">

    
    <link rel="stylesheet" href="{{ url('') }}/assets/plugins/select2/css/select2.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/dataTables.bootstrap4.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ url('') }}/assets/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ url('') }}/assets/css/style.css">


    @stack('styles')

    @livewireStyles

</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('inc.header')
        <!-- Header -->

        <!-- Sidebar -->
        @include('inc.sidebar')
        <!-- /Sidebar -->

        <div class="page-wrapper">
            @yield('content')
        </div>

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ url('') }}/assets/js/jquery-3.6.0.min.js"></script>

    <!-- Feather Icon JS -->
    <script src="{{ url('') }}/assets/js/feather.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="{{ url('') }}/assets/js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
	<script src="{{ url('') }}/assets/plugins/select2/js/select2.min.js"></script>

    <!-- Datatable JS -->
    <script src="{{ url('') }}/assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ url('') }}/assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ url('') }}/assets/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ url('') }}/assets/js/script.js"></script>

    <!-- Chart JS -->
    <script src="{{ url('') }}/assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/apexchart/chart-data.js"></script>


    @livewireScripts

    @stack('scripts')

</body>

</html>
