<!doctype html>
<html lang="en">
<head>
    @section('htmlheader') @include('adminlte::layouts.partials.htmlheader') @show
</head>


<body>
    <div class="wrapper">
        @include('adminlte::layouts.partials.sidebar')
        <div class="main-panel">
            @include('adminlte::layouts.partials.navbar')
            @yield('content')
            @include('adminlte::layouts.partials.footer')
        </div>
    </div>
</body>
@include('adminlte::layouts.partials.scripts_footer')
<script type="text/javascript">
$(document).ready(function() {

    // Javascript method's body can be found in Carcoin/js/demos.js
    demo.initDashboardPageCharts();

});
</script>
@yield('script')
</html>