<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css"> -->

    <link rel="stylesheet" href="{{asset('Carcoin/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('Carcoin/css/material-dashboard.css')}"/>
    <link rel="stylesheet" href="{{asset('Carcoin/css/demo.css')}}"/>
    <link rel="stylesheet" href="{{asset('Carcoin/css/custom.css')}}"/>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .result-set { margin-top: 1em }
    </style>
    <!-- Scripts -->
    <script type="text/javascript" src="{{asset('Carcoin/js/jquery-3.2.1.min.js')}}">script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    @yield('content')

    
    <!-- Scripts -->
    <script src="{{asset('Carcoin/js/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('Carcoin/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('Carcoin/js/material.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('Carcoin/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
    <!-- Library for adding dinamically elements -->
    <script src="{{asset('Carcoin/js/arrive.min.js')}}" type="text/javascript"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{asset('Carcoin/js/jquery.validate.min.js')}}"></script>
    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="{{asset('Carcoin/js/moment.min.js')}}"></script>
    <!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
    <script src="{{asset('Carcoin/js/chartist.min.js')}}"></script>
    <!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{asset('Carcoin/js/jquery.bootstrap-wizard.js')}}"></script>
    <!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
    <script src="{{asset('Carcoin/js/bootstrap-notify.js')}}"></script>
    <!--   Sharrre Library    -->
    <script src="{{asset('Carcoin/js/jquery.sharrre.js')}}"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{asset('Carcoin/js/bootstrap-datetimepicker.js')}}"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{asset('Carcoin/js/jquery-jvectormap.js')}}"></script>
    <!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
    <script src="{{asset('Carcoin/js/nouislider.min.js')}}"></script>
    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1_8C5Xz9RpEeJSaJ3E_DeBv8i7j_p6Aw"></script>
    <!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{asset('Carcoin/js/jquery.select-bootstrap.js')}}"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
    <script src="{{asset('Carcoin/js/jquery.datatables.js')}}"></script>
    <!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
    <script src="{{asset('Carcoin/js/sweetalert2.js')}}"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{asset('Carcoin/js/jasny-bootstrap.min.js')}}"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{asset('Carcoin/js/fullcalendar.min.js')}}"></script>
    <!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{asset('Carcoin/js/jquery.tagsinput.js')}}"></script>
    <!-- Material Dashboard javascript methods -->
    <script src="http://demos.creative-tim.com/material-dashboard-pro/assets/js/material-dashboard.js?v=1.2.1"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{asset('Carcoin/js/demo.js')}}"></script>


    <script src="{{ url (mix('/js/app.js')) }}"></script>

    @stack('scripts')

    <script>
        $(function () {
            // flash auto hide
            $('#flash-msg .alert').not('.alert-danger, .alert-important').delay(6000).slideUp(500);
        })
    </script>
</body>
</html>
