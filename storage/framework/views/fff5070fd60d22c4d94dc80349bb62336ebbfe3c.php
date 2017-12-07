<?php $__env->startSection('contentheader_title'); ?>
<?php echo e(trans('adminlte_lang::member.refferals')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="container-fluid">
        <div class="row d-flex" section="dashboard-status">
            <h3 class="m-0"></h3>
            <div class="" style="width:100%">


            <div class="card">
                    <!-- <div class="card-header card-header-icon" data-background-color="carcoin-primary-1">
                        <i class="material-icons">assignment</i>
                    </div> -->
                    <div class="card-content">
                        <h3 class="card-title">Referrals</h3>
                        <div class="table-responsive">
                        <table class="table dataTable">
                            <tr>
                                <th><?php echo e(trans('adminlte_lang::member.refferals_no')); ?></th>
                                <th><?php echo e(trans('adminlte_lang::member.refferals_id')); ?></th>
                                <th><?php echo e(trans('adminlte_lang::member.refferals_username')); ?></th>
                                <th><?php echo e(trans('adminlte_lang::member.refferals_fullname')); ?></th>
                                <th><?php echo e(trans('adminlte_lang::member.refferals_package')); ?></th>
                                <th><?php echo e(trans('adminlte_lang::member.refferals_more')); ?></th>
                                <th><?php echo e(trans('adminlte_lang::member.refferals_loyalty')); ?></th>
                            </tr>
                            <tbody>
                                <?php 
                                $i = 1
                                 ?>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($i++); ?></td>
                                    <td><?php echo e($userData->user->uid); ?></td>
                                    <td><?php echo e($userData->user->name); ?></td>
                                    <td><?php echo e($userData->user->name); ?></td>
                                    <td class="text-uppercase"><?php echo e($userData->package->name); ?></td>
                                    <td>
                                        <a href="<?php echo e(URL::to('members/referrals/'.$userData->user->uid.'/detail')); ?>" class="btn btn-xs btn-info pull-left" style="margin-right: 3px;margin-top: 1px;"><?php echo e(trans('adminlte_lang::default.btn_view')); ?></a>
                                    </td>
                                    <td>
                                        <?php if($userData->loyaltyId >0 ): ?>
                                        <?php echo e(config('cryptolanding.listLoyalty')[$userData->loyaltyId]); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>








        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>