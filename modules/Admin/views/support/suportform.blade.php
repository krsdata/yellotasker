
@extends('packages::layouts.master')
  @section('title', 'Dashboard')
    @section('header')
    <h1>Dashboard</h1>
    @stop
    @section('content') 
      @include('packages::partials.navigation')
      <!-- Left side column. contains the logo and sidebar -->
      @include('packages::partials.sidebar')
                             <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
             <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                      @include('packages::partials.breadcrumb')
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                      <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN VALIDATION STATES-->
                            <div class="portlet light portlet-fit portlet-form bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">
                                            
                                            Ticket Details : #{{ $ticketId}}

                                        </span>
                                    </div>
                                    
                                </div>
                                <div class="portlet-body">
                                    <!-- BEGIN FORM-->
                                
                                   {!! Form::open(['url' => 'admin/supportReply','class' => 'form-horizontal user-form','id'=>'user-form','method'=>'post']) !!}
                                   <input type="hidden" name="parent_id" value="{{$comments->id}}">
                                    
                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide">
                                            <button class="close" data-close="alert"></button> Please fill the required field! </div> 
                                      
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Ticket ID <span class="required"> * </span></label>
                                        <div class="col-md-6"> 
                                            <input type="text"  class="form-control" readonly name="ticket_id" value="{{$ticketId}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Reason Type <span class="required"> * </span></label>
                                        <div class="col-md-6"> 
                                            <input type="text"  class="form-control" readonly name="reason_type" value="{{$comments->reason->reasonType or ''}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Reason <span class="required"> * </span></label>
                                        <div class="col-md-6"> 
                                            <input type="text"  class="form-control" readonly name="subject" value="{{$comments->reason->reasonDescription or ''}}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Email <span class="required"> * </span></label>
                                        <div class="col-md-6">
                                            <input type="text"  class="form-control" name="email" readonly value="{{$comments->reportedUserDetail->email or ''}}">  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Current Status <span class="required"> * </span></label>
                                        <div class="col-md-6">
                                            <div class="" style="border: 1px solid #ccc; padding: 5px;"> 
                                                <span class="btn-success" style="padding: 5px;">{{$comments->status}}</span> 
                                            </div>
                                            
                                        </div>
                                    </div>
                                     
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Change Status <span class="required"> * </span></label>
                                        <div class="col-md-8">
                                             
                                                <div class="col-md-2">
                                                    <input type="radio" value="Open" name="status" @if($comments->status=='open' || $status=='open') checked @endif>Open 
                                                </div>
                                                <div class="col-md-2">
                                                <input name="status" type="radio" value="reopen" @if($comments->status=='reopen' || $status=='reopen') checked @endif>Reopen </div>
                                                <div class="col-md-2">
                                                <input name="status" type="radio" value="inprogress" @if($comments->status=='Inprogress' || $status=='Inprogress') checked @endif>In Progress
                                            </div>
                                            <div class="col-md-2">
                                                <input name="status" type="radio" value="resolved" @if($comments->status=='resolved' || $status=='resolved') checked @endif>Resolved
                                            </div>
                                            <div class="col-md-2">
                                                <input  name="status" type="radio" value="closed" @if($comments->status=='closed' || $status=='closed') checked @endif>Closed 
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group {{ $errors->first('description', ' has-error') }}">
                                        <label class="control-label col-md-3">Comment<span class="required"> </span></label>
                                        <div class="col-md-6"> 
                                         <input type="text"  class="form-control" name="user_comments" readonly value="{{$comments->comment or ''}}"> 
                                        </div>
                                    </div> 

                                  <div class="form-group {{ $errors->first('description', ' has-error') }}">
                                        <label class="control-label col-md-3">Support Reply<span class="required"> </span></label>
                                        <div class="col-md-6"> 
                                         <div class="" style="border: 1px solid #ccc; padding: 5px;"> 
                                      

                                            @if(!$allReply)
                                                NA
                                            @endif
                                            @foreach($allReply as $key =>$result)
                                            <label class="btn-success" style="padding: 5px;">Date :{{$result->updated_at }} </label>
                                            <div style="background-color: beige;padding:5px"> {!!$result->support_comments!!}
                                            </div>
                                             
                                            @endforeach
                                             </div>
                                        </div>
                                    </div>  

                                     <div class="form-group {{ $errors->first('reply', ' has-error') }}">
                                        <label class="control-label col-md-3">Add Reply<span class="required"> </span></label>
                                        <div class="col-md-6"> 
                                            {!! Form::textarea('support_comments','Dear User,', ['class' => 'form-control ckeditor form-cascade-control','data-required'=>1,'rows'=>3,'cols'=>5])  !!}  
                                            <span class="help-block">{{ $errors->first('support_comments', ':message') }}</span>
                                        </div>
                                    </div>
                                    <?php 
                                        $status = isset($_REQUEST['status'])?$_REQUEST['status']:'inprogress'; 
                                    ?> 
                                        
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                              {!! Form::submit('Add Reply', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!} 

                                               <a href="{{url(URL::previous())}}">
                                    {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                                            </div>
                                        </div>
                                    </div>

                                  
                                  {!! Form::close() !!}   
                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            
            
            <!-- END QUICK SIDEBAR -->
        </div>
        

        
@stop



