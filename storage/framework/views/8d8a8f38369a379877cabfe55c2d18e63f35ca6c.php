<?php $__env->startSection('htmlheader_title'); ?>
    Authentication
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<body class="hold-transition login-page off-canvas-sidebar">
<div id="app" class="wrapper wrapper-full-page">
    <div class="full-page login-page" filter-color="carcoin-secondary-1">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <div class="card card-login">
                                <div class="card-header text-center">
                                    <div class="logo">
                                        <a href="<?php echo e(url('/home')); ?>">
                                            <img src="<?php echo e(asset('Carcoin/img/zcoin-id-final_logo-rev.svg')); ?>">
                                        </a>
                                    </div>
                                </div>
                                <form action="/authenticator" method="post">
                                <h4 class="text-center">2FA Authenticator</h4>
                                    <?php echo csrf_field(); ?>

                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">email_circle</i>
                                            </span>
                                            
                                            <div class="form-group label-floating has-feedback<?php echo e($valid ? '' : ' has-error'); ?>">
                                                <label class="control-label">2FA Code</label>
                                                <input type="text" name="code" class="form-control"  value="<?php echo e(old('code')); ?>" placeholder="">
                                                <?php if($errors->has('')): ?>
                                                    <span class="help-block">
                                                        <strong><?php echo e($errors->first('code')); ?></strong>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="footer text-center">
                                        <button type="submit" class="btn btn-fill btn-primary btn-round" btn-sign-in><?php echo e(trans('adminlte_lang::default.submit')); ?></button>
                                        
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php echo $__env->make('adminlte::layouts.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>