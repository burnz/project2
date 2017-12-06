<?php $__env->startSection('contentheader_title'); ?>
    <?php echo e(trans('adminlte_lang::profile.my_profile')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if( session()->has("errorMessage") ): ?>
        <div class="callout callout-danger">
            <h4>Warning!</h4>
            <p><?php echo session("errorMessage"); ?></p>
        </div>
        <?php echo e(session()->forget('errorMessage')); ?>

    <?php elseif( session()->has("successMessage") ): ?>
        <div class="callout callout-success">
            <h4>Success</h4>
            <p><?php echo session("successMessage"); ?></p>
        </div>
        <?php echo e(session()->forget('successMessage')); ?>

    <?php else: ?>
        <div></div>
    <?php endif; ?>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title"><?php echo e(trans('adminlte_lang::profile.personal_data')); ?>

                                <div class="card-control"><button class="btn btn-primary btn-round btn-sm m-0" edit-personal-data>Edit</button></div>
                            </h4>
                            <?php echo e(Form::model(Auth::user(), array('route' => array('profile.update', Auth::user()->id,), 'method' => 'PUT'))); ?>

                                <div class="row">
                                    <h4 class="col-md-12">General</h4>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.my_id')); ?></label>
                                            <p  class="form-control"><?php echo e(Auth::user()->uid); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.username')); ?></label>
                                            <p  class="form-control"><?php echo e(Auth::user()->name); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.first_name')); ?></label>
                                            <p  class="form-control"><?php echo e(Auth::user()->firstname); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.last_name')); ?></label>
                                            <p  class="form-control"><?php echo e(Auth::user()->lastname); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.my_email')); ?></label>
                                            <p  class="form-control"><?php echo e(Auth::user()->email); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="col-md-12">Address</h4>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.street_address_1')); ?></label>
                                            <input type="text" class="form-control" name="address" value="<?php echo e(Auth::user()->address); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.street_address_2')); ?></label>
                                            <input type="text" class="form-control" name="address2" value="<?php echo e(Auth::user()->address2); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.city')); ?></label>
                                            <input type="text" class="form-control" name="city" value="<?php echo e(Auth::user()->city); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.state')); ?></label>
                                            <input type="text" class="form-control" name="state" value="<?php echo e(Auth::user()->state); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.postal_code')); ?></label>
                                            <input type="text" class="form-control" name="postal_code" value="<?php echo e(Auth::user()->postal_code); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.country')); ?></label>
                                            <p class="form-control"><?php echo e(Auth::user()->name_country); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h4 class="col-md-12">Contact</h4>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.phone')); ?></label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo e(Auth::user()->phone); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="label-control"><?php echo e(trans('adminlte_lang::profile.birthday')); ?></label>
                                            <?php if(Auth::user()->birthday): ?>
                                                <p class="form-control"><?php echo e(Auth::user()->birthday); ?></p>
                                            <?php else: ?>
                                                <input type="date" class="form-control" value="<?php echo e(Auth::user()->birthday); ?>" name="birthday" />
                                            <?php endif; ?>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><?php echo e(trans('adminlte_lang::profile.passport')); ?></label>
                                            <?php if(Auth::user()->passport): ?>
                                                <p class="form-control"><?php echo e(Auth::user()->passport); ?></p>
                                            <?php else: ?>
                                                <input type="text" class="form-control" name="passport" value="<?php echo e(Auth::user()->passport); ?>">
                                            <?php endif; ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="pull-right hide" btn-action-form>
                                    <button type="submit" class="btn btn-primary btn-round"><?php echo e(trans('adminlte_lang::profile.btn_save')); ?></button>
                                    <button type="button" class="btn btn-outline-primary btn-round" cancel-btn-action-form>Cancel</button>
                                </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="user.html#pablo">
                                <img class="img" src="<?php echo e(asset('Carcoin/img/user/avatar.jpg')); ?>" />
                            </a>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Tania Andrew</h4>
                            <p class="description">
                                <span>ID: 123456</span>
                                <span>Loyalty: Diadmond</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            demo.initFormExtendedDatetimepickers();

            $('form input').each(function(index, el) {
                $(el).prop('disabled',true);
            });

            $('[edit-personal-data]').click(function() {
                $('form input').each(function(index, el) {
                    $(el).removeAttr('disabled', '') ;
                });
                $('[btn-action-form]').removeClass('hide');
            });

            $('[cancel-btn-action-form]').click(function() {
                $('form input').each(function(index, el) {
                    console.log(el);
                    $(el).attr('disabled', '');
                });
                $('[btn-action-form]').addClass('hide');
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>