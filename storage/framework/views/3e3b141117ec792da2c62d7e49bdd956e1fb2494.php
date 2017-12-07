 
 
<?php $__env->startSection('content'); ?>
<div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                                    <i class="material-icons">perm_identity</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title"><?php echo e(trans('adminlte_lang::profile.security_settings')); ?></h4>
                                    <form class="" id="formchangpassword" _lpchecked="1">
                                        <div class="row" change-password>
                                            <h4 class="col-md-12"><?php echo e(trans('adminlte_lang::profile.change_password')); ?><div class="card-control"><a href="javascript:;" edit-change-password>Edit</a></div></h4>

                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="confirmSuccess" style="color:green">

                                                    </div>
                                                    <div class="confirmError" style="color:red">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><?php echo e(trans("adminlte_lang::profile.old_password")); ?></label>
                                                    <input type="password" class="form-control" id="inputPasswordOld">
                                                    <span style="color: red" id="errorOldPassword"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><?php echo e(trans("adminlte_lang::profile.new_password")); ?></label>
                                                    <input type="password" class="form-control" id="inputPasswordNew">
                                                    <span style="color: red" id="errorNewPassword"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group label-floating">
                                                    <label class="control-label"><?php echo e(trans("adminlte_lang::profile.confirm_password")); ?></label>
                                                    <input type="password" class="form-control" id="inputPasswordConfirm">
                                                    <span style="color: red" id="errorPasswordConfirm"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="pull-right" btn-action-change-password style="display: none;">
                                                    <button type="button" class="btn btn-primary btn-round" id="savePassword"><?php echo e(trans('adminlte_lang::profile.btn_save')); ?></button>
                                                    <button type="button" class="btn btn-outline-primary btn-round" cancel-btn-action-change-password>Cancel</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" authentication>
                                            <div class="col-md-12 d-flex my-3 justify-content-between">
                                                <div class="togglebutton">
                                                    <label class="h4" style="color: rgba(0, 0, 0, 0.87)"><?php echo e(trans('adminlte_lang::profile.two_factor_authen')); ?>

                                                        <input type="checkbox" class="ml-4" 2factorAuthentication id="switchAuthen" <?php echo e(Auth::user()->is2fa ? 'checked' : ''); ?>>
                                                    </label>
                                                </div>
                                                <div class="card-control align-self-center "><a href="#" edit-authentication>Edit</a></div>
                                            </div>
                                            <div class="col-md-6">
                                            <div id="2fa-google-barcode">
                                                <div class="qrcode">
                                                    <?php if(!Auth::user()->is2fa): ?>
                                                        <img src="<?php echo e($google2faUrl); ?>">
                                                    <?php else: ?>
                                                        <img src="">
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6" 2factorAuthentication-input style="display: none;">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">2FA Code</label>
                                                    <input type="text" class="form-control" id="codeOtp">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="pull-right" btn-action-authentication style="display: none;">
                                                    <button type="button" class="btn btn-primary btn-round" id="2FA_check">Save</button>
                                                    <button type="button" class="btn btn-outline-primary btn-round" cancel-btn-action-authentication>Cancel</button>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
    $(document).ready(function() {
        $('[change-password] input, [authentication] input').each(function(index, el) {
            $(el).attr('disabled', '');
        });

        $('[edit-change-password]').click(function() {
            event.preventDefault();
            $('[change-password] input').each(function(index, el) {
                $(el).prop('disabled', function(i, v) { return !v; });
            });
            $('[btn-action-change-password]').slideToggle('hide');
        });

        $('[cancel-btn-action-change-password]').click(function() {
            $('[edit-change-password]').trigger('click')
        });

        $('[edit-authentication]').click(function() {
            event.preventDefault();
            $('[authentication] input:not([2factorauthentication])').each(function(index, el) {
                $(el).prop('disabled', function(i, v) { return !v; });
            });
            $('[btn-action-authentication]').slideToggle('hide');
            $('[2factorauthentication-input]').slideToggle('hide');
            $('[2factorAuthentication]').prop('checked', function(i, v) { return !v; });
        });

        $('[cancel-btn-action-authentication]').click(function() {
            $('[edit-authentication]').trigger('click');
        });
        // $('[edit-authentication]').click(function() {
        //     event.preventDefault();
        //     if($('[2factorauthentication-input]').css('display')=='none')
        //     {
        //         $('[2factorauthentication-input]').css('display','block');
        //     }
        //     else
        //     {
        //         $('[2factorauthentication-input]').css('display','none');
        //     }
        //     $('[authentication] input').each(function(index, el) {
        //         $(el).prop('disabled', function(i, v) { return !v; });
        //     });
        //     $('[btn-action-authentication]').slideToggle('hide');
        // });

        // $('[cancel-btn-action-authentication]').click(function() {
        //     $('[edit-authentication]').trigger('click');
        // });


        $('[2factorAuthentication]').click(function() {
        });


        //update pasword
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //action Save Pass
        $( "#savePassword" ).click(function() {
                //compare password and password confirm
                if ( $( '#inputPasswordNew' ).val().trim().length < 6 ) {
                    $( '#errorNewPassword' ).show();
                    $( '#errorNewPassword' ).html("<?php echo e(trans('adminlte_lang::profile.minimum_password')); ?>");
                } else if( $( '#inputPasswordNew' ).val() != $( '#inputPasswordConfirm' ).val() ){
                    $( '#errorPasswordConfirm' ).show();
                    $( '#errorPasswordConfirm' ).html("<?php echo e(trans('adminlte_lang::profile.password_not_match')); ?>");
                } else {
                    //send password 
                    $.ajax({
                        beforeSend : function (){
                            $( "#savePassword i" ).removeClass("fa fa-save");
                            $( "#savePassword i" ).addClass("fa fa-refresh fa-spin");
                            $( "#savePassword" ).addClass("disabled");
                        },
                        url : "<?php echo e(url('profile/changepassword')); ?>",
                        type : "post",
                        data : {
                            _token:  $("meta[name='csrf-token']").attr("content"), 
                            new_password : $( '#inputPasswordNew' ).val(),
                            old_password : $( '#inputPasswordOld ').val(),
                            confirm_password: $( '#inputPasswordConfirm ').val()
                        },
                        success : function (result){
                            
                            if(result.errorcode == 1){
                                $( '#errorOldPassword' ).show();
                                $( '#errorOldPassword' ).html("<?php echo e(trans('adminlte_lang::profile.wrong_password')); ?>");
                            } else if (result.success){
                                $('#myModalChangePassword').modal('hide');
                                alert("<?php echo e(trans('adminlte_lang::profile.success')); ?>");
                            } else {
                                $('#myModalChangePassword').modal('hide');
                                alert("<?php echo e(trans('adminlte_lang::profile.fail')); ?>");
                            } 


                        }
                    })
                    .done(function(){
                        $( "#savePassword i" ).removeClass("fa fa-refresh fa-spin");
                        $( "#savePassword i" ).addClass("fa fa-save");
                        $( "#savePassword" ).removeClass("disabled");
                        $("#formchangpassword")[0].reset();
                    })
                    .fail(function(xhr, status, error){
                        console.log("<?php echo e(trans('adminlte_lang::profile.error')); ?>");
                    });  
                }
            });
        //end update password

        //action 2fa
        if(!$("#switchAuthen").is(':checked'))//off - on
        {
            $('#2FA_check').click(function(){
                var codeOtp = $.trim($('#codeOtp').val());
                if( codeOtp !=''){
                    $.ajax({
                        url : "<?php echo e(url('profile/switchauthen')); ?>",
                        data: {codeOtp: codeOtp, status:0},
                        type : "get",
                        success : function (result){
                            if(result.success){
                                document.getElementById('logout-form').submit();//logout user
                                //location.href = '<?php echo e(url()->current()); ?>';
                            }else{
                                alert(result.msg);
                            }
                        }
                    });
                }else{
                    alert('Please input 2FA code.');
                }
            });
        }
        else//on-off
        {
            $('#2FA_check').click(function(){
                var codeOtp = $.trim($('#codeOtp').val());
                if( codeOtp !=''){
                    $.ajax({
                        url : "<?php echo e(url('profile/switchauthen')); ?>",
                        data: {codeOtp: codeOtp, status:1},
                        type : "get",
                        success : function (result){
                            if(result.success){
                                location.href = '<?php echo e(url()->current()); ?>';
                            }else{
                                alert(result.msg);
                            }
                        }
                    });
                }else{
                    alert('Please input 2FA code.');
                }
            });
        }
        //end action 2fa

    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>