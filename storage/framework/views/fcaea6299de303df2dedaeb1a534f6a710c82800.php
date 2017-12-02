  <?php $__env->startSection('title', 'Dashboard'); ?>
    <?php $__env->startSection('header'); ?>
    <h1>Dashboard</h1>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('content'); ?> 
      <?php echo $__env->make('packages::partials.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php echo $__env->make('packages::partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php echo $__env->make('packages::program.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
<?php $__env->stopSection(); ?>
<?php echo $__env->make('packages::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>