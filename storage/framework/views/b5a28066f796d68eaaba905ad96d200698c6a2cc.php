<?php echo $__env->make('packages::layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldContent('content'); ?>
 <!---footer start her -->
<?php echo $__env->make('packages::layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>