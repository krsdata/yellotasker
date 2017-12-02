<h3 class="form-title">Sign in</h3>
     <?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
        <button class="close" data-close="alert"></button>
        <span> 
            
                    <?php foreach($errors->all() as $error): ?>
                    <?php echo e($error); ?>

                    <?php endforeach; ?>
                
        </span>
    </div>
     <?php endif; ?>
    <div class="form-group<?php echo e($errors->first('email', ' has-error')); ?>">
        <label class="control-label visible-ie8 visible-ie9"> email <span class="error">*</span></label>
        <div class="input-icon">
          
             <?php echo Form::email('email',null, ['class' => 'form-control placeholder-no-fix', 'placeholder'=>'Email' ]); ?> 
        </div>
    </div>
   <div class="form-group<?php echo e($errors->first('password', ' has-error')); ?>">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="input-icon">
            
            
             <?php echo Form::password('password', ['class' => 'form-control placeholder-no-fix', 'placeholder'=>'Password' ]); ?> 

            </div>
    </div>
  
       <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Login</button>
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
                    </label>
                    <a href="<?php echo e(url('admin/forgot-password')); ?>" id="forget-password" class="forget-password">Forgot Password?</a>
                </div>
                
                <div class="create-account">
                    <p>
                        <a href="javascript:;"  class="uppercase"></a>
                    </p>
                </div>