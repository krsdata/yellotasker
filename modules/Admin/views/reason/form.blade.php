 

<div class="form-body">
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div>
  <!--   <div class="alert alert-success display-hide">
        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
--> 

         <div class="form-group {{ $errors->first('reasonType', ' has-error') }}  @if(session('field_errors')) {{ 'has-group' }} @endif">
            <label class="col-md-3 control-label">Reason Type
                <span class="required"> * </span>
            </label>
            <div class="col-md-4"> 

                {{ Form::select('reasonType',$status, isset($reason->reasonType)?$reason->reasonType:'', ['class' => 'form-control']) }}
                <span class="help-block">{{ $errors->first('reasonType', ':message') }}</span>
            </div> 
        </div>


        
          <div class="form-group {{ $errors->first('reasonDescription', ' has-error') }}">
            <label class="control-label col-md-3">Description<span class="required"> </span></label>
            <div class="col-md-4"> 
                {!! Form::textarea('reasonDescription',null, ['class' => 'form-control','data-required'=>1,'rows'=>3,'cols'=>5])  !!} 
                
                <span class="help-block">{{ $errors->first('reasonDescription', ':message') }}</span>
            </div>
        </div> 


        
        
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
              {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


               <a href="{{route('program')}}">
    {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
            </div>
        </div>
    </div>


 