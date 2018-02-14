<style type="text/css">
 li.multiselect-all,li.multiselect-item {
    margin-left: 25px;
  }
  ul.multiselect-container > li{
     margin-left: 25px;
  }
</style> 

<div class="form-body">
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div>
  <!--   <div class="alert alert-success display-hide">
        <button class="close" data-close="alert"></button> Your form validation is successful! </div>
-->
 
    <div class="form-group {{ $errors->first('blog_title', ' has-error') }}">
            <label class="control-label col-md-3">Blog Title <span class="required"> * </span></label>
            <div class="col-md-4"> 
                {!! Form::text('blog_title',null, ['class' => 'form-control','data-required'=>1])  !!} 
                
                <span class="help-block">{{ $errors->first('blog_title', ':message') }}</span>
            </div>
        </div> 

         <div class="form-group{{ $errors->first('blog_description', ' has-error') }}">
        <label class="control-label col-md-3">Blog Description</label>
        <div class="col-md-8"> 
            {!! Form::textarea('blog_description',null, ['class' => 'form-control ckeditor form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('blog_description', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">
                {{ Session::get('flash_alert_notice') }} 
            </span>@endif
        </div>
    </div> 


       <div class="form-group {{ $errors->first('blog_category', ' has-error') }}">
        <label class="control-label col-md-3">Select Blog Category
            <span class="required">  </span>
        </label>
        <div class="col-md-4"> 
        <div class="portlet-body">
             <select class="mt-multiselect btn btn-default" multiple="multiple" data-label="right" data-select-all="true" data-width="100%"  name="blog_category[]" data-action-onchange="true">
                @foreach($categories as $key=>$value)
                <option value="{{$value->id}}" @if(isset($category_id) && (in_array($value->id,$category_id))) {{ 'selected="selected"'}}  @endif

                @if($value->id==old('blog_category'))  {{ 'selected="selected"'}} @endif
                  >

                {{ $value->category_name }}
                
                </option>
                @endforeach
            </select>
            </div>
            <span class="help-block">{{ $errors->first('blog_category', ':message') }}</span>
        </div>
    </div> 

     


         <div class="form-group {{ $errors->first('blog_type', 'has-error') }}">
            <label class="control-label col-md-3">Blog Type  </label>
            <div class="col-md-4">  
               {{ Form::select('blog_type',$type, array_search($blog->blog_type, $type), ['class' => 'form-control']) }}
                
                <span class="help-block">{{ $errors->first('blog_type', ':message') }}</span>
            </div>
        </div> 


         <div class="form-group {{ $errors->first('blog_created_by', 'has-error') }}">
            <label class="control-label col-md-3">Author  </label>
            <div class="col-md-4"> 
                {!! Form::text('blog_created_by',null, ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('blog_created_by', ':message') }}</span>
            </div>
        </div> 




         <div class="form-group {{ $errors->first('blog_image', ' has-error') }}">
            <label class="control-label col-md-3">Blog Images  </label>
            <div class="col-md-4"> 
                  {!! Form::file('blog_image',null,['class' => 'form-control'])  !!}
             <br>
              @if(isset($blog->blog_image))
              <img src="{!! Url::to('storage/blog/'.$blog->blog_image) !!}" width="150px">
              @endif                                   
            <span class="label label-danger">{{ $errors->first('blog_image', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif

            </div>
        </div>  
    
    
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
         <!--  {!! Form::button(' Save ', ['class'=>'btn save  btn-primary text-white','id'=>'saveBtn']) !!} -->
          {!! Form::submit('Save', ['class'=>'btn save btn-primary text-white','id'=>'saveBtn']) !!}


           <a href="{{route('blog')}}">
{!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>

 