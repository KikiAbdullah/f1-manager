<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('asset_materialize') }}/" data-template="vertical-menu-template"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $title . ' - ' . env('APP_NAME') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('asset_materialize/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/fonts/remixicon/remixicon.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/fonts/flag-icons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('asset_materialize/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('asset_materialize/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('asset_materialize/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/libs/sweetalert2/sweetalert2.css') }}" />



    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/css/pages/cards-statistics.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset_materialize/vendor/css/pages/cards-analytics.css') }}" />

    @yield('customcss')

    <!-- Helpers -->
    <script src="{{ asset('asset_materialize/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('asset_materialize/js/config.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/js/bootstrap.js') }}"></script>

    <script type="text/javascript">
        const _csrf_token = "{{ csrf_token() }}";
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _csrf_token
                }
            });
        });
    </script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.menu')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('layouts.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.inner-footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
    @yield('appmodal')

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('asset_materialize/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('asset_materialize/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('asset_materialize/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('app_local/js/settings.js') }}"></script>



    <!-- Main JS -->
    <script src="{{ asset('asset_materialize/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('asset_materialize/js/dashboards-crm.js') }}"></script>

    @yield('customjs')
</body>

</html>
