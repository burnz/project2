<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.register')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="wrapper wrapper-full-page">
<div class="full-page register-page" filter-color="carcoin-secondary-1">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-12">
                <div class="card-signup p-0">
                    <div class="row d-flex">
                        <div class="col-md-3 col-md-offset-1 align-self-center">
                            <div class="card-content" sign-up-step>
                                <div class="info info-horizontal">
                                    <div class="icon active">
                                        <i class="material-icons">done</i>
                                    </div>
                                    <div class="description">
                                        <h4 class="info-title">Register</h4>
                                    </div>
                                </div>
                                
                                <div class="info info-horizontal">
                                    <div class="icon"></div>
                                    <div class="description">
                                        <h4 class="info-title">Active</h4>
                                    </div>
                                </div>
                                
                                <div class="info info-horizontal">
                                    <div class="icon end"></div>
                                    <div class="description">
                                        <h4 class="info-title">Complete</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <form class="form" method="" action="register.html">
                                    <div class="card-header text-center">
                                        <div class="logo"><img src="../../../assets/img/zcoin-id-final_logo-rev.svg"></div>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-md-12 p-0">
                                                <div class="col-xs-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">account_circle</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">First Name</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">account_circle</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Last Name</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">account_circle</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">User Name</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">contact_phone</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Phone</label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">mail_outline</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Email</label>
                                                            <input type="email" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">lock_outline</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Password</label>
                                                            <input type="password" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-6">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="material-icons">lock_outline</i>
                                                        </span>
                                                        <div class="form-group label-floating">
                                                            <label class="control-label">Retype Password</label>
                                                            <input type="password" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex my-4">
                                            <div class="col-xs-12 align-self-center">
                                                <div class="checkbox form-horizontal-checkbox">
                                                    <label>
                                                        <input type="checkbox" name="optionsCheckboxes"> <a href="#">Terms and conditions</a>
                                                    </label>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <button type="button" class="btn btn-fill btn-primary btn-round" btn-sign-up>Sign up</button>
                                        <div class="clearfix"></div>
                                        <div class="my-3"><a href="#">I already have a membership</a></div>
                                    </div>
                                </form>
                            </div>
                        </div>
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