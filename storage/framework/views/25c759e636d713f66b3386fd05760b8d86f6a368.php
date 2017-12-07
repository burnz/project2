<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.login')); ?>

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
                                    <form action="<?php echo e(url(config('adminlte.login_url', 'login'))); ?>" method="post">
                                        <?php echo csrf_field(); ?>

                                        <div class="card-content">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">account_circle</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                                    <label class="control-label">Email</label>
                                                    <input type="email" name="email" class="form-control"  value="<?php echo e(old('email')); ?>" placeholder="">
                                                    <?php if($errors->has('email')): ?>
                                                        <span class="help-block">
                                                            <strong><?php echo e($errors->first('email')); ?></strong>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                                <div class="form-group label-floating has-feedback <?php echo e($errors->has('password') ? 'has-error' : ''); ?>" >
                                                    <label class="control-label">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                    <?php if($errors->has('password')): ?>
                                                        <span class="help-block">
                                                            <strong><?php echo e($errors->first('password')); ?></strong>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if(Config::get('app.enable_captcha')): ?>
                                                <div class="form-group">
                                                    <?php echo app('captcha')->display(); ?>

                                                    <?php if($errors->has('g-recaptcha-response')): ?>
                                                        <span class="help-block">
                                                            <?php echo e($errors->first('g-recaptcha-response')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="row d-flex my-4">
                                                <div class="col-xs-7 align-self-center">
                                                    <div class="checkbox form-horizontal-checkbox">
                                                        <label>
                                                            <input type="checkbox" name="remeber"> <?php echo e(trans('adminlte_lang::default.remember_me')); ?>

                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xs-5 align-self-center p-0">
                                                    <a href="<?php echo e(url('/password/reset')); ?>"><?php echo e(trans('adminlte_lang::message.forgotpassword')); ?></a>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="footer text-center">
                                            <button type="submit" class="btn btn-fill btn-primary btn-round" btn-sign-in><?php echo e(trans('adminlte_lang::default.btn_sign_in')); ?></button>
                                            <div class="clearfix"></div>
                                            <div class="my-3">Still no account? Please go to <a href="<?php echo e(url('register')); ?>">Sign up</a></div>
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
    <?php echo $__env->make('adminlte::layouts.partials.scripts_footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>


    </body>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>