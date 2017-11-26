  <?php $__env->startSection('title', 'Dashboard'); ?>
    <?php $__env->startSection('header'); ?>
    <h1>Dashboard</h1>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?> 
      <?php echo $__env->make('packages::partials.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php echo $__env->make('packages::partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
       <!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
<!-- BEGIN PAGE HEAD-->

<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
<?php echo $__env->make('packages::partials.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row">
    <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET--> 
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase"><?php echo e($heading); ?></span>
                </div>
                 
            </div>
                  
            <?php if(Session::has('flash_alert_notice')): ?>
                 <div class="alert alert-success alert-dismissable" style="margin:10px">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                  <i class="icon fa fa-check"></i>  
                 <?php echo e(Session::get('flash_alert_notice')); ?> 
                 </div>
            <?php endif; ?>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row"> 

                        <div class="modal-body">
            <div class="post-detail-left">
                <div class="detail-pic-name">
                    <div class="pic-name-left">
                        <img src="<?php echo e(url('storage/image/poster-big.png')); ?>" alt="">
                    </div>
                    <div class="pic-name-right"> 

                        <h4><?php echo e(isset($postTasks->user->first_name) ? $postTasks->user->first_name : 'NA'); ?><span class="follow-ico"><a href="#">
                        <img src="<?php echo e(url('storage/image/follow.png')); ?>"></a></span>

                        </h4>
                        <p><?php echo e(isset($postTasks->user->email) ? $postTasks->user->email : 'NA'); ?> <?php echo e(isset($postTasks->user->phone) ? $postTasks->user->phone : ''); ?></p>
                        <p><a href="#">
                            <img src="<?php echo e(url('storage/image/open.png')); ?>">

                        </a> &nbsp;&nbsp;<a href="#"><img src="<?php echo e(url('storage/image/assigned.png')); ?>"></a> &nbsp;&nbsp;<a href="#"><img src="<?php echo e(url('storage/image/complete.png')); ?>"></a></p>
                    </div>
                </div>
                <div class="post-description">
                    <h4>Description</h4>
                    <p>
                     <b><?php echo e($postTasks->title); ?></b>
                    </p>
                    <p>
                      
                      <?php echo e($postTasks->description); ?>


                    </p>
                    <br>
                    <h4>Requirement</h4>
                    <p><?php echo e($postTasks->title); ?></p>
                    <p>
                        <img src="<?php echo e(url('storage/image/map.jpg')); ?>" alt="" width="100%;">
                    </p>
                </div>
            </div>
            <div class="post-detail-right">
                            <h4>Task Budget</h4>
                            <div class="rate">
                                <p class="main-price">
                                            $<?php echo e($postTasks->totalAmount); ?>

                                            <span>Approx. <?php echo e($postTasks->totalHours); ?>Hrs</span>
                                </p>
                                <p class="make-offer">
                                            
                                </p>
                            </div>
                                <div class="popup-location">
                                    <div class="pop-location-nav">
                                        <i class="fa fa-location-arrow"></i>
                                    </div>
                                    <div class="pop-location-desc">
                                        <h5><?php echo e(isset($postTasks->address) ? $postTasks->address : 'NA'); ?></h5>
                                        <p>
                                            
                                            <?php echo e($postTasks->zipcode); ?>

                                        </p>
                                    </div>
                                    
                                </div>
                                <div class="popup-location">
                                    <div class="pop-location-nav">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="pop-location-desc">
                                        <h5>Posted by <?php echo e($postBy); ?></h5>
                                        <p><?php echo e($postTasks->address); ?> <br><?php echo e($postTasks->zipcode); ?>

                                        </p>
                                    </div>
                                    
                                </div>
                                <div class="offers-pop">
                                    
                                </div>
                            </div>
                      </div>
                                 
                
                    </div> 
                </div>
            <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    <!-- END PAGE BASE CONTENT -->
    </div>
<!-- END CONTENT BODY -->
</div> 

<!-- END QUICK SIDEBAR -->
</div> 
        
<?php $__env->stopSection(); ?>
<?php echo $__env->make('packages::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>