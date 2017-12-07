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
<?php echo $__env->make('adminlte::layouts.partials.scripts_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script type="text/javascript">
$(document).ready(function() {

    // Javascript method's body can be found in Carcoin/js/demos.js
    demo.initDashboardPageCharts();

});
</script>

</html>