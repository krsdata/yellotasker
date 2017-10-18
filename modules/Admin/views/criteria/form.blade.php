
<div class="col-md-6">

    <div class="form-group{{ $errors->first('interview_criteria', ' has-error') }}">
        <label class="col-lg-4 col-md-4 control-label"> Interview criteria <span class="error">*</span></label>
        <div class="col-lg-8 col-md-8"> 
            {!! Form::text('interview_criteria',null, ['class' => 'form-control form-cascade-control input-small'])  !!} 
            <span class="label label-danger">{{ $errors->first('interview_criteria', ':message') }}</span>
        </div>
    </div> 

    
    
    <div class="form-group">
        <label class="col-lg-4 col-md-4 control-label"></label>
        <div class="col-lg-8 col-md-8">

            {!! Form::submit('Save', ['class'=>'btn btn-primary text-white']) !!}
        </div>
    </div>

</div> 