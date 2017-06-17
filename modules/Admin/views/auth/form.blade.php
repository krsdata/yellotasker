<div class="form-group{{ $errors->first('email', ' has-error') }} has-feedback">
    {!! Form::email('email',null, ['class'=>'form-control', 'placeholder'=>Lang::get('admin-lang.email')]) !!}
		<span class="glyphicon glyphicon-envelope form-control-feedback input-img"></span>
	 	 
</div>

<div class="form-group{{ $errors->first('password', ' has-error') }} has-feedback">
   {!! Form::password('password',['class'=>'form-control','placeholder'=> Lang::get('password')]) !!}
		<span class="glyphicon glyphicon-lock form-control-feedback input-img"></span>
		 
</div>

<div class="form-group alert alert-danger error-loc " style="display:none"></div>
	<p>
        @if(Session::has('flash_alert_notice'))
        <div class="alert alert-danger danger">
             {{ Session::get('flash_alert_notice') }} 
        </div>
      @endif
  	</p>

<div class="row">
<div class="col-xs-8"></div><!-- /.col -->
<div class="col-xs-4">
<!--   <button type="submit" class="btn btn-primary btn-block btn-flat">{{ Lang::get('admin-lang.sign_in') }}</button> -->
    {!! Form::submit(Lang::get('admin-lang.sign_in'), ['class'=>'btn btn-primary btn-block btn-flat', 'id'=>'login', 'value'=>  Lang::get('admin-lang.sign_in') ]) !!}
</div><!-- /.col -->
</div>