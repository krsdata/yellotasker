

<div class="form-group{{ $errors->first('name', ' has-error') }}">
    <label class="col-lg-3 col-md-3 control-label"> Name <span class="error">*</span></label>
    <div class="col-lg-9 col-md-9"> 
        {!! Form::text('name',$users->name, ['class' => 'form-control form-cascade-control input-small'])  !!} 
          <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
    </div>
  </div> 

   <div class="form-group{{ $errors->first('email', ' has-error') }}">
    <label class="col-lg-3 col-md-3 control-label"> Email <span class="error">*</span></label>
    <div class="col-lg-9 col-md-9"> 
        {!! Form::text('email',$users->email, ['class' => 'form-control form-cascade-control input-small'])  !!} 
          <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
    </div>
  </div> 
   <div class="form-group{{ $errors->first('password', ' has-error') }}">
    <label class="col-lg-3 col-md-3 control-label"> Password <span class="error">*</span></label>
    <div class="col-lg-9 col-md-9"> 
        {!! Form::text('password',null, ['class' => 'form-control form-cascade-control input-small','placeholder'=>'******'])  !!} 
          <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
    </div>
  </div> 

  <div class="form-group">
      <label class="col-lg-3 col-md-3 control-label"></label>
      <div class="col-lg-9 col-md-9">
          {!! Form::submit('Update', ['class'=>'btn btn-primary text-white']) !!}
      </div>
  </div> 
