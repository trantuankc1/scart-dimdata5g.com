<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin</title>

    <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="{{ asset('agency_css/assets/images/favicon.png') }}"
    />
    <!-- Custom CSS -->
    <link href="{{ asset('agency_css/assets/libs/flot/css/float-chart.css') }}" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link href="{{ asset('agency_css/dist/css/style.min.css') }}" rel="stylesheet"/>
    <style>
        body {
            background-color: #fdfbfb;
        }
    </style>
</head>
<body>
<div
        id="main-wrapper"
        data-layout="vertical"
        data-navbarbg="skin5"
        data-sidebartype="full"
        data-sidebar-position="absolute"
        data-header-position="absolute"
        data-boxed-layout="full"
>
    <!-- Topbar header - style you can find in pages.scss -->
    @include('dashboard_agency.layout.header')
    <!-- End Topbar header -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    @include('dashboard_agency.layout.left_sidebar')
    @yield('content')
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
</div>


<script src="{{ asset('agency_css/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('agency_css/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('agency_css/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('agency_css/assets/extra-libs/sparkline/sparkline.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('agency_css/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('agency_css/dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('agency_css/dist/js/custom.min.js') }}"></script>
<!--This page JavaScript -->
<!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="{{ asset('agency_css/assets/libs/flot/excanvas.js') }}"></script>
<script src="{{ asset('agency_css/assets/libs/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('agency_css/assets/libs/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('agency_css/assets/libs/flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('agency_css/assets/libs/flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('agency_css/assets/libs/flot/jquery.flot.crosshair.js') }}"></script>
<script src="{{ asset('agency_css/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('agency_css/dist/js/pages/chart/chart-page-init.js') }}"></script>
</body>
</html>
