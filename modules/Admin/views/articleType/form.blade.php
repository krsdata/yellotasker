

            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> Please fill the required field! </div> 
			  
                 <div class="form-group {{ $errors->first('resolution_department', ' has-error') }}">
                 <label class="control-label col-md-3">Select Resolution Department
                        <span class="required">  </span>
                    </label>
                <div class="col-md-4"> 
                 <select name="resolution_department" class="form-control">
                   <option value="">Select Resolution Department</option>
                    @foreach($support as $key=>$value)
                    
                    <option value="{{$value}}" @if(isset($result['resolution_department']) &&  $value==$result['resolution_department']) {{ 'selected="selected"'}}  @endif 

                    @if($value==old('resolution_department'))  {{ 'selected="selected"'}} @endif
                      >
                    
                    {{ ucfirst($value) }}   
                    
                    </option>
                    @endforeach
                    </select>
                    <span class="help-block">{{ $errors->first('resolution_department', ':message') }}</span>
                </div>
            </div> 
            <div class="form-group {{ $errors->first('article_type', ' has-error') }}
            @if(session('field_errors')) {{ 'has-error' }} @endif
            ">
                    <label class="control-label col-md-3">Article Category Type <span class="required"> * </span></label>
                    <div class="col-md-4"> 
                        {!! Form::text('article_type',null, ['class' => 'form-control','data-required'=>1])  !!} 
                        <span class="help-block">{{ $errors->first('article_type', ':message') }} @if(session('field_errors')) {{ 'The article type name already been taken!' }} @endif </span>
                    </div>
                </div> 
                 
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!} 

                       <a href="{{route('articleType')}}">
                            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                    </div>
                </div>
            </div> 