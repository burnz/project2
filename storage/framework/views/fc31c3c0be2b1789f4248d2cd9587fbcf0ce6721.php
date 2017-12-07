 <?php 
    $url =  URL::to('login');
    $countdownTime = config("app.count_down_time_login");
    header( "refresh:$countdownTime;url=$url" ); 
    ?>



<?php $__env->startSection('htmlheader_title'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<body class="off-canvas-sidebar">
<div class="wrapper wrapper-full-page">
    <div class="full-page register-page" filter-color="carcoin-secondary-1">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-10 col-md-offset-1">
                    <div class="card-signup">
                        <div class="row d-flex">
                            <div class="col-md-5 col-md-offset-1 align-self-center">
                                <div class="card-content" sign-up-step>
                                    <div class="info info-horizontal">
                                        <div class="icon"></div>
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
                                        <div class="icon active end">
                                            <i class="material-icons">done</i>
                                        </div>
                                        <div class="description">
                                            <h4 class="info-title">Complete</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 align-self-center">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <div class="logo"><img src="<?php echo e(asset('Carcoin/img/zcoin-id-final_logo-rev.svg')); ?>"></div>
                                    </div>
                                    <form class="form">
                                        <div class="card-content text-center">
                                            <div class="h3 mb-2">You have actived your account successfully.<br> <small><a href="<?php echo e(URL::to('login')); ?>">Signing in</a> in after <span id="timer"><?php echo e(config("app.count_down_time_login")); ?> secs</span>...</small></div>

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
</body>
    <script>
        var count = <?php echo e(config("app.count_down_time_login")); ?>;
        var counter = setInterval(timer,1000);
        
        function timer()
        {
          count=count-1;
          if (count < 0)
          {
             clearInterval(counter);
             return;
          }

         document.getElementById("timer").innerHTML=count + " secs"; // watch for spelling
        }
        
       
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>