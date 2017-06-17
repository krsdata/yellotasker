
<div class="col-md-6">


     <div class="form-group{{ $errors->first('course_id', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Choose Course </label>
        <div class="col-lg-8 col-md-8"> 
           <select name="course_id" class="form-control form-cascade-control">
            @foreach($course as $key=>$value)
            
            <option value="{{$value->id}}" {{($value->id ==$syllabus->course_id)?"selected":""}}>{{ $value->course_name }}</option>
            @endforeach
            </select>
            <span class="label label-danger">{{ $errors->first('course_id', ':message') }}</span>
        </div>
    </div>  

    <div class="form-group{{ $errors->first('syllabus_title', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Syllabus Title <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('syllabus_title',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('syllabus_title', ':message') }}</span>
        </div>
    </div> 

     <div class="form-group{{ $errors->first('syllabus_description', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Syllabus Description <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('syllabus_description',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('syllabus_description', ':message') }}</span>
        </div>
    </div> 

     <div class="form-group{{ $errors->first('grade_weight', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Grade weight *</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('grade_weight',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('grade_weight', ':message') }}</span>
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

            <a href="{{route('syllabus')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 