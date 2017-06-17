
<div class="col-md-6">
 
<!-- 
    <div class="form-group{{ $errors->first('syllabus_id', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Select Syllabus </label>
        <div class="col-lg-8 col-md-8"> 
           <select name="syllabus_id" class="form-control form-cascade-control">
            @foreach($syllabus  as $key=>$value)
            
            <option value="{{$value->id}}" {{($value->id == $assignment->syllabus_id)?"selected":""}}>{{ $value->syllabus_title }}</option>
            @endforeach
            </select>
            <span class="label label-danger">{{ $errors->first('syllabus_id', ':message') }}</span>
        </div>
    </div>   -->

 
     <div class="form-group{{ $errors->first('syllabus_id', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Select Syllabus </label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::select('syllabus_id',$syllabi, ($assignment->syllabus_id)?$assignment->syllabus_id:null,['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('syllabus_id', ':message') }}</span>
        </div>
    </div> 

<!--     <div class="form-group{{ $errors->first('course_id', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Select Course </label>
        <div class="col-lg-8 col-md-8"> 
           <select name="course_id" class="form-control form-cascade-control">
            @foreach($course  as $key=>$value)
            
            <option value="{{$value->id}}" {{($value->id == $assignment->course_id)?"selected":""}}>{{ $value->course_name }}</option>
            @endforeach
            </select>
            <span class="label label-danger">{{ $errors->first('course_id', ':message') }}</span>
        </div>
    </div>   -->


    <div class="form-group{{ $errors->first('paper_title', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Paper title <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('paper_title',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('paper_title', ':message') }}</span>
        </div>
    </div> 

    <div class="form-group{{ $errors->first('chapter', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Chapter *</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('chapter',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('chapter', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger"> 
                {{ Session::get('flash_alert_notice') }}  
            </span>@endif
        </div>
    </div>

     <div class="form-group{{ $errors->first('duration', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Assignment Duration </label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('duration',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('duration', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger"> 
                {{ Session::get('flash_alert_notice') }}  
            </span>@endif
        </div>
    </div>

     <div class="form-group{{ $errors->first('description', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Assignment Description </label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('description',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('description', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger"> 
                {{ Session::get('flash_alert_notice') }}  
            </span>@endif
        </div>
    </div>

     <div class="form-group{{ $errors->first('type', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">type </label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('type',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('type', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger"> 
                {{ Session::get('flash_alert_notice') }}  
            </span>@endif
        </div>
    </div>


    <div class="form-group{{ $errors->first('grade', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Grade *</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('grade',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('grade', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger"> 
                {{ Session::get('flash_alert_notice') }}  
            </span>@endif
        </div>
    </div> 

       <div class="form-group{{ $errors->first('due_date', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Due Date *</label>
        <div class="col-lg-8 col-md-8 date"> 
 
            {!! Form::text('due_date',null, ['class' => 'form-control form-cascade-control input-small','id'=>'datepicker'])  !!} 
            <i class="fa fa-calendar" style="
    position: absolute;
    top: 10px; 
    right: 20px;"></i>
            <span class="label label-danger">{{ $errors->first('due_date', ':message') }}</span>
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

            <a href="{{route('assignment')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 