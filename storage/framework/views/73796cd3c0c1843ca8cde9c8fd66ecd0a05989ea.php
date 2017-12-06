<!doctype html>
<html lang="en">
<?php $__env->startSection('htmlheader'); ?> <?php echo $__env->make('adminlte::layouts.partials.htmlheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php echo $__env->yieldSection(); ?>

<body>
    <div class="wrapper">
        <?php echo $__env->make('adminlte::layouts.partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="main-panel">
            <?php echo $__env->make('adminlte::layouts.partials.navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('adminlte::layouts.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="/Carcoin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/Carcoin/js/material.min.js" type="text/javascript"></script>
<script src="/Carcoin/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->
<!-- Library for adding dinamically elements -->
<script src="/Carcoin/js/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="/Carcoin/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="/Carcoin/js/moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="/Carcoin/js/chartist.min.js"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="/Carcoin/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="/Carcoin/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<script src="/Carcoin/js/jquery.sharrre.js"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="/Carcoin/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="/Carcoin/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="/Carcoin/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1_8C5Xz9RpEeJSaJ3E_DeBv8i7j_p6Aw"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="/Carcoin/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="/Carcoin/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="/Carcoin/js/sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="/Carcoin/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="/Carcoin/js/fullcalendar.min.js"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="/Carcoin/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="/Carcoin/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="/Carcoin/js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    // Javascript method's body can be found in Carcoin/js/demos.js
    demo.initDashboardPageCharts();

});
</script>

</html>