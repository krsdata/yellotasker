
<div class="col-md-10">

             @if(Session::has('flash_alert_notice2')) 
            
                <div class="alert alert-success">    {{ Session::get('flash_alert_notice2') }} </div>
            @endif
    
     <div class="form-group{{ $errors->first('website_title', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Website Title <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('website_title',isset($website_title->field_value)?$website_title->field_value:null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('website_title', ':message') }}</span>
        </div>
    </div>

     <div class="form-group{{ $errors->first('website_email', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Website email <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('website_email',isset($website_email->field_value)?$website_email->field_value:null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('website_email', ':message') }}</span>
        </div>
    </div>  
  

    <div class="form-group{{ $errors->first('website_url', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Website URL</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('website_url',isset($website_url->field_value)?$website_url->field_value:'http://', ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('website_url', ':message') }}</span>
        </div>
    </div> 

    <div class="form-group{{ $errors->first('contact_number', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Contact Number</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('contact_number',isset($contact_number->field_value)?$contact_number->field_value:'+91', ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('contact_number', ':message') }}</span>
        </div>
    </div> 

 

     <div class="form-group{{ $errors->first('company_address', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Company Address</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::textarea('company_address',isset($company_address->field_value)?$company_address->field_value:null, ['class' => 'form-control ckeditor form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('company_address', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif
        </div>
    </div> 
<hr> <center> <b> Banner  (minimum size : 800x350) </b> </a><hr>
     <div class="form-group{{ $errors->first('image', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Banner Image1 </label>
        <div class="col-lg-8 col-md-8">  

             {!! Form::file('banner_image1',null,['class' => 'form-control form-cascade-control input-small'])  !!}
             <br>
             @foreach($banner as $key => $value)
             @if($value->field_key=='banner_image1')
                 <img src="{!! Url::to('storage/files/banner/'.$value->field_value) !!}" width="100px" height="100px">
              @endif    
             @endforeach                                 
            <span class="label label-danger">{{ $errors->first('banner_image1', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif
        </div>
    </div> 


     <div class="form-group{{ $errors->first('image', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Banner Image2 </label>
        <div class="col-lg-8 col-md-8">  

             {!! Form::file('banner_image2',null,['class' => 'form-control form-cascade-control input-small'])  !!}
             <br>
             @foreach($banner as $key => $value)
             @if($value->field_key=='banner_image2')
                 <img src="{!! Url::to('storage/files/banner/'.$value->field_value) !!}" width="100px" height="100px">
              @endif    
             @endforeach   

            <span class="label label-danger">{{ $errors->first('banner_image2', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif
        </div>
    </div> 


     <div class="form-group{{ $errors->first('image', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Banner Image3</label>
        <div class="col-lg-8 col-md-8">  

             {!! Form::file('banner_image3',null,['class' => 'form-control form-cascade-control input-small'])  !!} 
              <br>
            @foreach($banner as $key => $value)
                @if($value->field_key=='banner_image3')
                     <img src="{!! Url::to('storage/files/banner/'.$value->field_value) !!}" width="100px" height="100px">
                 @endif    
            @endforeach      
                                               
            <span class="label label-danger">{{ $errors->first('banner_image3', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger">

                {{ Session::get('flash_alert_notice') }} 

            </span>@endif
        </div>
    </div> 

      
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-8 col-md-8">

            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}

            <a href="{{route('product')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 
