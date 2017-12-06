<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<?php $__env->startSection('htmlheader'); ?>
    <?php echo $__env->make('adminlte::layouts.partials.htmlheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

<script src="/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/AdminLTE/bower_components/bootstrap/dist/js/bootstrap-confirmation.min.js"></script>
<script src="/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/AdminLTE/dist/js/app.js"></script>
<body class="skin-purple sidebar-mini">
<div>
    <div class="wrapper">

    <?php echo $__env->make('adminlte::layouts.partials.mainheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('adminlte::layouts.partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 0px !important;">

        <?php echo $__env->make('adminlte::layouts.partials.contentheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Main content -->
        <section class="content">
            <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- Your Page Content Here -->
            <div class="rows" >
               <?php echo $__env->yieldContent('main-content'); ?>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    
    <?php echo $__env->make('adminlte::layouts.partials.controlsidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('adminlte::layouts.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    

 

    </div><!-- ./wrapper -->
</div>
</body>
</html>
