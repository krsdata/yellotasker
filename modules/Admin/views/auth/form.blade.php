<h3 class="form-title">Login to your account</h3>
     @if (count($errors) > 0)
    <div class="alert alert-danger">
        <button class="close" data-close="alert"></button>
        <span> 
            
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                
        </span>
    </div>
     @endif
    <div class="form-group{{ $errors->first('email', ' has-error') }}">
        <label class="control-label visible-ie8 visible-ie9"> email <span class="error">*</span></label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
             {!! Form::email('email',null, ['class' => 'form-control placeholder-no-fix', 'placeholder'=>'Email' ])  !!} 
        </div>
    </div>
   <div class="form-group{{ $errors->first('password', ' has-error') }}">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            
             {!! Form::password('password', ['class' => 'form-control placeholder-no-fix', 'placeholder'=>'Password' ])  !!} 

            </div>
    </div>
    <div class="form-actions">
        <label class="rememberme mt-checkbox mt-checkbox-outline">
            <input type="checkbox" name="remember" value="1" /> Remember me
            <span></span>
        </label>
        <button type="submit" class="btn green pull-right"> Login </button>
    </div>
    
    <div class="forget-password">
        <h4>Forgot your password ?</h4>
        <p> no worries, click
            <a href="javascript:;" id="forget-password"> here </a> to reset your password. </p>
    </div>
     