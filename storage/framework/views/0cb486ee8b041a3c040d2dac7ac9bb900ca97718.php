 

<div class="form-body">
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div>
  <!--   <div class="alert alert-success display-hide">
        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
--> 

         <div class="form-group <?php echo e($errors->first('reasonType', ' has-error')); ?>  <?php if(session('field_errors')): ?> <?php echo e('has-group'); ?> <?php endif; ?>">
            <label class="col-md-3 control-label">Reason Type
                <span class="required"> * </span>
            </label>
            <div class="col-md-4"> 

                <?php echo e(Form::select('reasonType',$status, isset($reason->reasonType)?$reason->reasonType:'', ['class' => 'form-control'])); ?>

                <span class="help-block"><?php echo e($errors->first('reasonType', ':message')); ?></span>
            </div> 
        </div>


        
          <div class="form-group <?php echo e($errors->first('reasonDescription', ' has-error')); ?>">
            <label class="control-label col-md-3">Description<span class="required"> </span></label>
            <div class="col-md-4"> 
                <?php echo Form::textarea('reasonDescription',null, ['class' => 'form-control','data-required'=>1,'rows'=>3,'cols'=>5]); ?> 
                
                <span class="help-block"><?php echo e($errors->first('reasonDescription', ':message')); ?></span>
            </div>
        </div> 


        
        
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
              <?php echo Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']); ?>



               <a href="<?php echo e(route('program')); ?>">
    <?php echo Form::button('Back', ['class'=>'btn btn-warning text-white']); ?> </a>
            </div>
        </div>
    </div>


 