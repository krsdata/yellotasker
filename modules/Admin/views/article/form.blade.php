

            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> Please fill the required field! </div>
           
			  
                 <div class="form-group {{ $errors->first('article_type', ' has-error') }}">
                 <label class="control-label col-md-3">Select Article Type
                        <span class="required">  </span>
                    </label>
                <div class="col-md-8"> 
                 <select name="article_type" class="form-control">
                   <option value="">Select article type </option>
                    @foreach($article_types as $key=>$value)
                     
                    <option value="{{$value->id}}" @if(isset($result->article_type) && ($value->id==$result->article_type) || (isset($id) && $id==$value->id)) {{ 'selected="selected"'}}  @endif  
                    @if($value->id==old('article_type'))  {{ 'selected="selected"'}} @endif 
                      >
                    
                       {{ $value->article_type }}
                    
                    </option>
                    @endforeach
                    </select>
                    <span class="help-block">{{ $errors->first('article_type', ':message') }}</span>
                </div>
            </div> 
            <div class="form-group {{ $errors->first('article_title', ' has-error') }}
            @if(session('field_errors')) {{ 'has-error' }} @endif
            ">
                    <label class="control-label col-md-3">Article Title <span class="required"> * </span></label>
                    <div class="col-md-8"> 
                        {!! Form::text('article_title',null, ['class' => 'form-control','data-required'=>1,'required'])  !!} 
                        <span class="help-block">{{ $errors->first('article_title', ':message') }}  
                    </div>
                </div>  
                
                <div class="form-group {{ $errors->first('description', ' has-error') }}">
                    <label class="control-label col-md-3">Description<span class="required"> </span></label>
                    <div class="col-md-8"> 
                        {!! Form::textarea('description',null, ['class' => 'form-control ckeditor form-cascade-control','data-required'=>1,'rows'=>3,'cols'=>5])  !!}  
                        <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                    </div>
                </div> 
                
                
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!} 

                       <a href="{{route('article')}}">
{!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                    </div>
                </div>
            </div>




<div class="form-body">





</div> 

