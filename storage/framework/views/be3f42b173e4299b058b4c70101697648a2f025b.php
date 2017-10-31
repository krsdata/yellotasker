<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="<?php echo e(url('/')); ?>">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="<?php echo e(url($route_url)); ?>"><?php echo e($heading); ?></a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active"><?php echo e($page_action); ?></span>
    </li>
</ul>
