<div class="tab-pane active" id="tab_1_1"> 
<div class="portlet light bordered">
 <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase">Personel Info
                </span>
            </div> 
        </div>
   

    <div class="form-group {{ $errors->first('first_name', ' has-error') }}">
        <label class="control-label">First Name</label>
        <input type="text" placeholder="First Name" class="form-control" name="first_name" 
        value="{{ ($user->first_name)?$user->first_name:old('first_name')}}"> </div>
    <div class="form-group {{ $errors->first('last_name', ' has-error') }}" >
        <label class="control-label">Last Name</label>
        <input type="text" placeholder="Last Name" class="form-control" name="last_name" value="{{ ($user->last_name)?$user->last_name:old('last_name')}}">  
    </div>
     <div class="form-group {{ $errors->first('email', ' has-error') }}">
        <label class="control-label ">Email</label>
        <input type="email" placeholder="Email" class="form-control" name="email" value="{{ ($user->email)?$user->email:old('email')}}"> 
    </div>
    <div class="form-group {{ $errors->first('password', ' has-error') }}">
        <label class="control-label">Password</label>
        <input type="password" placeholder="******" class="form-control" name="password"> 
    </div>

    @if($user->role_type==3)
     <div class="form-group {{ $errors->first('password', ' has-error') }}">
        <label class="control-label">Role Type</label>
          <select name="role_type" class="form-control select2me">
               <option value="">Select Roles...</option>
                 <option value="3" selected="selected">Customer</option>
                
                </select>
                <span class="help-block">{{ $errors->first('role_type', ':message') }}</span>
    </div>

    @else
     <div class="form-group {{ $errors->first('role_type', ' has-error') }}">
        <label class="control-label">Role Type</label>
          <select name="role_type" class="form-control select2me">
               <option value="">Select Roles...</option>
                @foreach($roles as $key=>$value)
                
                <option value="{{$value->id}}" {{($value->id ==$role_id)?"selected":"selected"}}>{{ $value->name }}</option>
                @endforeach
                </select>
                <span class="help-block">{{ $errors->first('role_type', ':message') }}</span>
    </div>

    @endif 
    <div class="form-group {{ $errors->first('skills', ' has-error') }}">
        <label class="control-label">Skills</label>
        <input type="text" placeholder="Skills" class="form-control" name="skills" value="{{$user->skills}}"> </div>



    <div class="form-group">
        <label class="control-label">Language</label>
        <input type="text" placeholder="Language" class="form-control" name="language" value="{{$user->language}}">
         </div>
    <div class="form-group {{ $errors->first('about_me', ' has-error') }}">
        <label class="control-label">About</label>
        <textarea class="form-control" rows="3" placeholder="Basic detail" name="about_me">{{$user->about_me}}</textarea>
    </div>

    <div class="form-group {{ $errors->first('location', ' has-error') }}">
        <label class="control-label">Location</label>
        <textarea class="form-control" rows="3" placeholder="Address" name="location" >{{$user->location}}</textarea>
    </div>
    <div class="form-group {{ $errors->first('birthday', ' has-error') }}">
        <label class="control-label">Birthday</label>
        <input type="text" placeholder="Birthday" class="form-control" id="startdate" name="birthday" value="{{$user->birthday}}"> 
    </div>
     <div class="form-group {{ $errors->first('phone', ' has-error') }}">
        <label class="control-label">Mobile Number</label>
        <input type="text" placeholder="Mobile or Phone" class="form-control" name="phone"  value="{{ ($user->phone)?$user->phone:old('phone')}}"> </div>
    <div class="form-group">
        <label class="control-label">Qualification</label>
        <input type="text" placeholder="qualification" class="form-control" name="qualification" value="{{$user->qualification}} "> 
    </div>

     <div class="form-group">
        <label class="control-label">Work Experience</label>
        <input type="number" placeholder="workExperience" class="form-control" min=0 name="workExperience" value="{{$user->workExperience}}"> 
    </div>
      @if($user->role_type==3)
     <div class="form-group">
        <label class="control-label">Percentage Completion</label>
        <input type="number" placeholder="percentage Completion" class="form-control" name="percentageCompletion" value="{{$user->percentageCompletion}}"> 
    </div>
@endif
    @if($user->role_type==3)
    <div class="form-group">
        <label class="control-label">Rating</label>
        <input type="text" placeholder="rating" class="form-control" name="rating" value="{{$user->rating}}"> 
    </div>
    <div class="form-group">
        <label class="control-label">Rating</label>
        <input type="text" placeholder="rating" class="form-control" name="rating" value="{{$user->rating}}"> 
    </div>
    <div class="form-group">
        <label class="control-label">Tag Line</label>
        <input type="text" placeholder="tagLine" class="form-control" name="tagLine" value="{{$user->tagLine}}"> 
    </div>

     <div class="form-group">
        <label class="control-label">Mode Of Reach</label>
        <input type="text" placeholder="Mode Of Reach" class="form-control" name="modeOfreach" value="{{$user->modeOfreach}}"> 
    </div>
    
    @endif
     <div class="margin-top-10">

                <button type="submit" class="btn green" value="personelInfo" name="submit"> Save </button>
                <button type="submit" class="btn default"> Cancel </button>
            </div>  
</div>
</div>