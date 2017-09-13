 

<div class="form-body">
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div>
  <!--   <div class="alert alert-success display-hide">
        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
-->
 
    <div class="form-group {{ $errors->first('name', ' has-error') }}">
                                                <label class="control-label col-md-3">Name <span class="required"> * </span></label>
                                                <div class="col-md-4"> 
                                                    {!! Form::text('name',null, ['class' => 'form-control','data-required'=>1])  !!} 
                                                    
                                                    <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                                                </div>
                                            </div> 

                                            <div class="form-group {{ $errors->first('phone', ' has-error') }}">
                                                <label class="control-label col-md-3">Phone <span class="required"> *  </span></label>
                                                <div class="col-md-4"> 
                                                    {!! Form::text('phone',null, ['class' => 'form-control','data-required'=>1,'min'=>10])  !!} 
                                                    
                                                    <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
                                                </div>
                                            </div> 


                                            <div class="form-group {{ $errors->first('email', ' has-error') }}  @if(session('field_errors')) {{ 'has-group' }} @endif">
                                                <label class="col-md-3 control-label">Email 
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-4"> 
                                                        
                                                 {!! Form::email('email',null, ['class' => 'form-control','data-required'=>1])  !!} 
                                                <span class="help-block" style="color:red">{{ $errors->first('email', ':message') }} @if(session('field_errors')) {{ 'The email has already been taken.' }} @endif</span>
       
                                                </div> 
                                            </div>

    
                                        <div class="form-group {{ $errors->first('address', ' has-error') }}">
                                            <label class="control-label col-md-3">Address<span class="required"> </span></label>
                                            <div class="col-md-4"> 
                                                {!! Form::textarea('address',null, ['class' => 'form-control','data-required'=>1,'rows'=>3,'cols'=>5])  !!} 
                                                
                                                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                                            </div>
                                        </div> 
    
    
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
          {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


           <a href="{{route('category')}}">
{!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>




<div class="form-body">





</div> 

