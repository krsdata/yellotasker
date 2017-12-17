

        <div class="form-body">
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button> Please fill required field! </div>
            <div class="alert alert-success display-hide">
                <button class="close" data-close="alert"></button> Your form validation is successful! </div>

		 	<div class="form-group {{ $errors->first('first_name', ' has-error') }}">
		        <label class="control-label col-md-3">First Name <span class="required"> * </span></label>
		        <div class="col-md-4"> 
		            {!! Form::text('first_name',null, ['class' => 'form-control','data-required'=>1])  !!} 
		            
		            <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
		        </div>
		    </div> 

            <div class="form-group {{ $errors->first('last_name', ' has-error') }}">
                <label class="control-label col-md-3">Last Name <span class="required"> * </span></label>
                <div class="col-md-4"> 
                    {!! Form::text('first_name',null, ['class' => 'form-control','data-required'=>1])  !!} 
                    
                    <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                </div>
            </div>  

		    <div class="form-group {{ $errors->first('phone', ' has-error') }}">
		        <label class="control-label col-md-3">Phone  </label>
		        <div class="col-md-4"> 
		            {!! Form::text('phone',null, ['class' => 'form-control','data-required'=>1,'min'=>10])  !!} 
		            
		            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
		        </div>
		    </div> 


            <div class="form-group {{ $errors->first('email', ' has-error') }}  @if(session('field_errors')) {{ 'has-group' }} @endif">
                <label class="col-md-3 control-label">Email Address
                    <span class="required"> * </span>
                </label>
                <div class="col-md-4"> 
                        
                 {!! Form::email('email',null, ['class' => 'form-control','data-required'=>1])  !!} 
                <span class="help-block" style="color:red">{{ $errors->first('email', ':message') }} @if(session('field_errors')) {{ 'The email has already been taken.' }} @endif</span>

                </div> 
            </div>
           	<div class="form-group {{ $errors->first('password', ' has-error') }}">
	        <label class="control-label col-md-3">Password <span class="required"> * </span></label>
	        <div class="col-md-4"> 
	            {!! Form::password('password', ['class' => 'form-control','data-required'=>1])  !!} 
	            
	            <span class="help-block">{{ $errors->first('password', ':message') }}</span>
	        </div>
	    </div> 
            
             
        <div class="form-group {{ $errors->first('role', ' has-error') }}">
	         <label class="control-label col-md-3">Role
                    <span class="required">  </span>
                </label>
	        <div class="col-md-4"> 
	           <select name="role" class="form-control select2me">
	           <option value="">Select Roles...</option>
	            @foreach($roles as $key=>$value)
	            
	            <option value="{{$value->id}}" {{($value->id ==$role_id)?"selected":"selected"}}>{{ $value->name }}</option>
	            @endforeach
	            </select>
	            <span class="help-block">{{ $errors->first('role', ':message') }}</span>
	        </div>
	    </div> 


        <!--     <div class="form-group">
                <label class="control-label col-md-3">DOB</label>
                <div class="col-md-4">
                    <div class="input-group date date-picker" data-date-format="dd-mm-yyyy">
                        <input type="text" class="form-control" readonly name="datepicker">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                 <!--    <span class="help-block"> select a date </span>
                </div>
            </div>   -->

            
            
          <!--   <div class="form-group">
                <label class="control-label col-md-3">Remarks</label>
                <div class="col-md-9">
                    <textarea name="markdown" data-provide="markdown" rows="10" data-error-container="#editor_error"></textarea>
                    <div id="editor_error"> </div>
                </div>
            </div> -->

            
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


<div class="form-body">





</div> 

