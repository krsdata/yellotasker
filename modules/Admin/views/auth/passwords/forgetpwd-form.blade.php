d<div class="form-group{{ $errors->first('email', ' has-error') }} has-feedback">
    {!! Form::email('email',null, ['class'=>'form-control', 'placeholder'=>'Email']) !!}
    <span class="glyphicon glyphicon-envelope form-control-feedback input-img"></span> 
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
      {!! Form::submit(Lang::get('immoclick-lang.submit'), ['class'=>'btn btn-primary btn-block btn-flat', 'id'=>'login', 'value'=>  Lang::get('immoclick-lang.sign_in') ]) !!}
    </div> 
  </div>