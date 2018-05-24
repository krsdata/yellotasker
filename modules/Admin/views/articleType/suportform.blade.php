
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
                                
                                  {!! Form::model($result, ['route' => ['supportTicket'],'class'=>'form-horizontal user-form','id'=>'user-form','enctype'=>'multipart/form-data']) !!}
                                    
                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide">
                                            <button class="close" data-close="alert"></button> Please fill the required field! </div>

                                      
                                         <div class="form-group {{ $errors->first('article_type', ' has-error') }}">
                                         <label class="control-label col-md-3">Support Type
                                                <span class="required">  </span>
                                            </label>
                                        <div class="col-md-8"> 
                                       <input type="text"  class="form-control"  readonly="" value="{{ $result->supportType->resolution_department or 'General' }}">
                                        </div>
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Email <span class="required"> * </span></label>
                                        <div class="col-md-8">
                                            <input type="text"  class="form-control" name="email" readonly value="{{$result->email or 'NA'}}">  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Subject <span class="required"> * </span></label>
                                        <div class="col-md-8"> 
                                            <input type="text"  class="form-control" readonly value="{{$result->subject or 'NA'}}">  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Ticket ID <span class="required"> * </span></label>
                                        <div class="col-md-8"> 
                                            <input type="text"  class="form-control" readonly name="ticket_id" value="{{$result->ticket_id or 'NA'}} ">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Task Url <span class="required"> * </span></label>
                                        <div class="col-md-8"> 
                                            <input type="text"  class="form-control" readonly  value="{{$result->taskUrl or 'NA'}}">  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Attachment <span class="required"> * </span></label>
                                        <div class="col-md-8"> 
                                            <input type="text"  class="form-control" readonly value="{{$result->attachment or 'NA'}}">  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Status <span class="required"> * </span></label>
                                        <div class="col-md-8"> 
                                            <input type="text"  class="form-control" readonly  value="{{$result->status or 'NA'}}">  
                                        </div>
                                    </div>
                                    
                                    <div class="form-group {{ $errors->first('description', ' has-error') }}">
                                        <label class="control-label col-md-3">Description<span class="required"> </span></label>
                                        <div class="col-md-8"> 
                                         <div style="border: 1px solid #ccc; padding: 5px;"> {!!$result->description!!} </div>
                                        </div>
                                    </div> 

                                  <!--   <div class="form-group {{ $errors->first('description', ' has-error') }}">
                                        <label class="control-label col-md-3">Previous Reply<span class="required"> </span></label>
                                        <div class="col-md-8"> 
                                         <div class="" style="border: 1px solid #ccc; padding: 5px;"> 
                                            <p>{!!$result->reply!!}</p>

                                            <label class="btn btn-success" style="border-radius: 5px !important">date : {{date('Y')}}</label> </div>
                                        </div>
                                    </div>  -->

                                     <div class="form-group {{ $errors->first('reply', ' has-error') }}">
                                        <label class="control-label col-md-3">Add Reply<span class="required"> </span></label>
                                        <div class="col-md-8"> 
                                            {!! Form::textarea('reply',null, ['class' => 'form-control ckeditor form-cascade-control','data-required'=>1,'rows'=>3,'cols'=>5])  !!}  
                                            <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                                        </div>
                                    </div>
                                    <?php 
                                        $status = isset($_REQUEST['status'])?$_REQUEST['status']:'inprogress'; 
                                    ?>
                                    <input type="hidden" name="status" value="{{$status}}">    
                                        
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                              {!! Form::submit('Add Reply', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!} 

                                               <a href="{{url('admin/supportTicket')}}">
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



