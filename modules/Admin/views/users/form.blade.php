  <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill required field! 
    </div>
    <div class="alert alert-success display-hide">
        <button class="close" data-close="alert"></button> Your form validation is successful! 
    </div>

<div class="col-md-12" style="padding-top: 35px">
        <div class="col-md-6">
            <div class="form-group {{ $errors->first('first_name', ' has-error') }}">
                <label class="control-label col-md-4">First Name <span class="required"> * </span></label>
                <div class="col-md-8"> 
                    {!! Form::text('first_name',null, ['class' => 'form-control','data-required'=>1])  !!} 

                    <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                </div>
            </div> 
            <div class="form-group {{ $errors->first('email', ' has-error') }}  @if(session('field_errors')) {{ 'has-group' }} @endif">
                <label class="col-md-4 control-label">Email Address
                    <span class="required"> * </span>
                </label>
                <div class="col-md-8"> 

                             {!! Form::email('email',null, ['class' => 'form-control','data-required'=>1])  !!} 
                <span class="help-block" style="color:red">{{ $errors->first('email', ':message') }} @if(session('field_errors')) {{ 'The email has already been taken.' }} @endif</span>
                </div> 
            </div>
           
            
             <div class="form-group {{ $errors->first('password', ' has-error') }}">
            <label class="control-label col-md-4">Password <span class="required"> * </span></label>
            <div class="col-md-8"> 
                {!! Form::password('password', ['class' => 'form-control','data-required'=>1,'placeholder'=>'*****'])  !!} 

                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
            </div>
        </div> 
        </div>
        
        <div class="col-md-6">
          <div class="form-group {{ $errors->first('last_name', ' has-error') }}">
            <label class="control-label col-md-4">Last Name </label>
            <div class="col-md-8"> 
                {!! Form::text('last_name',null, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
            </div>
        </div>
          <div class="form-group {{ $errors->first('phone', ' has-error') }}">
            <label class="control-label col-md-4">Phone  </label>
            <div class="col-md-8"> 
                {!! Form::text('phone',null, ['class' => 'form-control','data-required'=>1,'min'=>10])  !!} 

                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->first('role', ' has-error') }}">
           <label class="control-label col-md-4">Role
               <span class="required">  </span>
           </label>
           <div class="col-md-8"> 
               <select name="role" class="form-control select2me" style="height: 45px;">
              <option value="">Select Roles...</option>
               @foreach($roles as $key=>$value) 
               <option value="{{$value->id}}" {{($value->id ==$role_id)?"selected":"selected"}}>{{ $value->name }}</option>
               @endforeach
               </select>
               <span class="help-block">{{ $errors->first('role', ':message') }}</span>
           </div>
       </div> 
       
    </div>
    
    </div> 
                                    
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
               <div class="col-md-2">
                   <button type="submit" class="btn col-md-12 blue mt-ladda-btn ladda-button" data-style="slide-up" id="saveBtn"> 
                            <span class="ladda-label"> Save </span>
                          <span class="ladda-spinner"></span>
                          <div class="ladda-progress" style="width: 0px;">
                          </div>
                        </button>
                    </div>
                <div class="col-md-2">    

                        <a href="{{route('user')}}">
                    {!! Form::button('Back', ['class'=>'btn btn-warning col-md-12 text-white']) !!} </a>
                </div>            
            </div>
        </div>
    </div> 