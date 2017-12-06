<?php $__env->startSection('content'); ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" section="wallet-panel">
                    <div class="card-header">
                        <h3 class="card-title text-center" style="position: relative;">
                            My Wallet
                        </h3>
                    </div>
                    <div class="card-content">
                        <div class="nav-center">
                            <ul class="nav nav-pills nav-pills-primary nav-pills-icons" role="tablist">
                                <li class="active">
                                    <a href="panels.html#pill1" role="tab" data-toggle="tab">
                                        <i class="material-icons" icon="img" size="lg"><img src="/Carcoin/img/bitcoin-symbol.svg"></i> Bitcoin Wallet
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-center mb-3" user-wallet>
                                        <div class="user-wallet">
                                            <div class="left">
                                                <i class="material-icons" icon="img" size="lg"><img
                                                        src="/Carcoin/img/bitcoin-symbol.svg"></i>
                                            </div>
                                            <div class="right">
                                                <span>Your Balance</span>
                                                <div class="content bitcoin-color">
                                                    314,675
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align-self-center">
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal"
                                                    data-target="#bitcoin-deposit">
                                                                        <span class="btn-label">
                                                                            <i class="material-icons">shop</i>
                                                                        </span> Deposit
                                                <div class="ripple-container"></div>
                                            </button>
                                            <button class="btn btn-thirdary btn-round" data-toggle="modal"
                                                    data-target="#bitcoin-withdraw">
                                                                        <span class="btn-label">
                                                                            <i class="material-icons reflect">shop</i>
                                                                        </span> Withdraw
                                                <div class="ripple-container"></div>
                                            </button>
                                            <!-- <button class="btn btn-thirdary btn-round" data-toggle="modal"
                                                    data-target="#bitcoin-buy-carcoin">
                                                                        <span class="btn-label">
                                                                            <i class="material-icons">add_shopping_cart</i>
                                                                        </span> Buy Carcoin
                                                <div class="ripple-container"></div>
                                            </button> -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card-content p-0">
                                            <!-- <div class="card-filter clearfix">
                                                <div class="col-md-4">
                                                    <div class="form-group label-floating">
                                                        <label class="control-label">Select Type</label>
                                                        <select class="form-control">
                                                            <option disabled="" selected=""></option>
                                                            <option value="2">Buy Carcoin</option>
                                                            <option value="3">Sell Carcoin</option>
                                                            <option value="4">Withdraw</option>
                                                            <option value="5">Deposit</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary btn-round">Filter
                                                    </button>
                                                    <button type="button" class="btn btn-outline-primary btn-round">
                                                        Clear
                                                    </button>
                                                </div>
                                            </div> -->
                                            <div class="clearfix"></div>
                                            <!-- <h4 class="card-title">Command</h4> -->
                                            <div class="table-responsive">
                                                <table class="table" cellspacing="0" width="100%" style="width:100%">
                                                    <thead class="text-thirdary">
                                                        <th><?php echo e(trans('adminlte_lang::wallet.wallet_no')); ?></th>
                                                        <th><?php echo e(trans('adminlte_lang::wallet.wallet_date')); ?></th>
                                                        <th><?php echo e(trans('adminlte_lang::wallet.wallet_type')); ?></th>
                                                        <th><?php echo e(trans('adminlte_lang::wallet.wallet_in')); ?></th>
                                                        <th><?php echo e(trans('adminlte_lang::wallet.wallet_out')); ?></th>
                                                        <th><?php echo e(trans('adminlte_lang::wallet.wallet_info')); ?></th>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td><?php echo e($key+1); ?></td>
                                                                <td><?php echo e($wallet->created_at); ?></td>
                                                                <td><?php echo e($wallet_type && isset($wallet_type[$wallet->type]) ? $wallet_type[$wallet->type] : ''); ?></td>
                                                                <td>
                                                                    <?php if($wallet->inOut=='in'): ?>
                                                                        +<?php echo e(number_format($wallet->amount, 5)); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($wallet->inOut=='out'): ?>
                                                                        -<?php echo e(number_format($wallet->amount, 5)); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                                <td><?php echo e($wallet->note); ?></td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>
                                                <div class="text-center">
                                                    <?php echo e($wallets->links()); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('adminlte::wallets.wallet-modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>