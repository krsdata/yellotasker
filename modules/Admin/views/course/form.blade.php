
<div class="col-md-6">


     <div class="form-group{{ $errors->first('professor_id', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Select professor </label>
        <div class="col-lg-8 col-md-8"> 
           <select name="professor_id" class="form-control form-cascade-control">
            @foreach($users as $key=>$value)
            
            <option value="{{$value->id}}" {{($value->id ==$course->professor_id)?"selected":""}}>{{ $value->name }}</option>
            @endforeach
            </select>
            <span class="label label-danger">{{ $errors->first('professor_id', ':message') }}</span>
        </div>
    </div> 
   


    <div class="form-group{{ $errors->first('course_name', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Course Title <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('course_name',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('course_name', ':message') }}</span>
        </div>
    </div> 

    <div class="form-group{{ $errors->first('session_id', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">Session id *</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('session_id',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('session_id', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger"> 
                {{ Session::get('flash_alert_notice') }}  
            </span>@endif
        </div>
    </div>

      <div class="form-group{{ $errors->first('general_info', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label">General Info *</label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('general_info',null, ['class' => 'form-control form-cascade-control input-small'])  !!}
            <span class="label label-danger">{{ $errors->first('general_info', ':message') }}</span>
            @if(Session::has('flash_alert_notice')) 
            <span class="label label-danger"> 
                {{ Session::get('flash_alert_notice') }}  
            </span>@endif
        </div>
    </div>

<!-- 
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
 --> 
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-8 col-md-8">

            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}

            <a href="{{route('course')}}">
            {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>

</div> 