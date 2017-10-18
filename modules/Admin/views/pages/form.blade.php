<div class="form-group{{ $errors->first('name', ' has-error') }}">
    {!! Form::label('name', 'Name:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name',null, ['class'=>'form-control', 'placeholder'=>'Kilometers']) !!}
        <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
    </div>
</div>

<div class="form-group{{ $errors->first('symbol', ' has-error') }}">
    {!! Form::label('symbol', 'Symbol:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('symbol', null, ['class'=>'form-control', 'placeholder'=>'Kms']) !!}
        <span class="label label-danger">{{ $errors->first('symbol', ':message') }}</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        <input type="button" class="btn btn-primary" value="Back" onclick="return window.history.back();">
    </div>
</div>
