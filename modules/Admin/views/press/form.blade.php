

            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> Please fill the required field! </div>
            
            <div class="form-group {{ $errors->first('pressName', ' has-error') }}
            @if(session('field_errors')) {{ 'has-error' }} @endif
            ">
            <label class="control-label col-md-3">Press Name <span class="required"> * </span></label>
            <div class="col-md-8"> 
                {!! Form::text('pressName',null, ['class' => 'form-control','data-required'=>1,'required'])  !!} 
                <span class="help-block">{{ $errors->first('pressName', ':message') }}  
            </div>
        </div>  
        

            <div class="form-group {{ $errors->first('link', ' has-error') }}
            @if(session('field_errors')) {{ 'has-error' }} @endif
            ">
            <label class="control-label col-md-3">Link <span class="required"> * </span></label>
            <div class="col-md-8"> 
                {!! Form::text('link',null, ['class' => 'form-control','data-required'=>1,'required'])  !!} 
                <span class="help-block">{{ $errors->first('link', ':message') }}  
            </div>
        </div>  
                
                
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!} 

                       <a href="{{route('press')}}">
{!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                    </div>
                </div>
            </div>

 

