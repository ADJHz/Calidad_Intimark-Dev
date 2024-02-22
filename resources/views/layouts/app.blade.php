<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Intimark-Calidad') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/Intimark.ico">
    <link rel="icon" type="image/ico" href="{{ asset('material') }}/img/Intimark.ico">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>

    <script>
        jQuery.event.special.touchstart = {
          setup: function (_, ns, handle) {
            this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
          }
        };

        jQuery.event.special.touchmove = {
          setup: function (_, ns, handle) {
            this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
          }
        };

        jQuery.event.special.wheel = {
          setup: function (_, ns, handle) {
            this.addEventListener("wheel", handle, { passive: true });
          }
        };

        jQuery.event.special.mousewheel = {
          setup: function (_, ns, handle) {
            this.addEventListener("mousewheel", handle, { passive: true });
          }
        };
      </script>
    <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
    <!-- Core Scripts -->
    <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>

    <!-- Select2 and Datepicker Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- Other Plugins -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="{{ asset('material') }}/js/settings.js"></script>
    <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>

</head>
<body class="{{ $class ?? '' }}">
    @auth()
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @include('layouts.page_templates.auth')
    @endauth
    @guest()
        @include('layouts.page_templates.guest')
    @endguest
    <!-- Other Scripts -->
    <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
    <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
    <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
    <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('material') }}/demo/demo.js"></script>
    @stack('js')
</body>

</html>
