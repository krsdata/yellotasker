 

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


         <div class="form-group {{ $errors->first('blog_description', ' has-error') }}">
            <label class="control-label col-md-3">Blog description  </label>
            <div class="col-md-4"> 
                {!! Form::text('blog_description',null, ['class' => 'form-control'])  !!} 
                
                <span class="help-block">{{ $errors->first('blog_description', ':message') }}</span>
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
          {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


           <a href="{{route('blog')}}">
{!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>

 