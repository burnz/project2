<?php 
    use App\Http\Controllers\News\DisplayNewsController as News;
    $tempNews = new News();
    $news = $tempNews->getNewsDataDisplay();
    $title = $tempNews->category;
    $i = 1;
?>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark control-sidebar-close" style="max-height: 1200px; overflow-y: scroll;">
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <h3 class="control-sidebar-heading"><?php echo e($title[$i]); ?></h3>
                <ul class='control-sidebar-menu'>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $new): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li title="read more...">
                    <a href="/news/detail/<?php echo e($new->id); ?>">
                        <i class="<?php if($i == 0): ?>
                           menu-icon fa fa-newspaper-o bg-yellow
                           <?php elseif($i == 1): ?>
                           menu-icon fa fa-newspaper-o bg-red
                           <?php elseif($i == 2): ?>
                           menu-icon fa fa-newspaper-o bg-light-blue
                           <?php else: ?>
                           menu-icon fa fa-newspaper-o bg-green
                           <?php endif; ?>
                           "></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">
                                <?php echo e($new->title); ?>

                            </h4>
                            <p><?php echo e($new->short_desc); ?></p>
                        </div>
                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php $i++ ;?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab"><?php echo e(trans('adminlte_lang::message.statstab')); ?></div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading"><?php echo e(trans('adminlte_lang::message.generalset')); ?></h3>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <?php echo e(trans('adminlte_lang::message.reportpanel')); ?>

                        <input type="checkbox" class="pull-right" <?php echo e(trans('adminlte_lang::message.checked')); ?> />
                    </label>
                    <p>
                        <?php echo e(trans('adminlte_lang::message.informationsettings')); ?>

                    </p>
                </div><!-- /.form-group -->
            </form>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar

<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>
