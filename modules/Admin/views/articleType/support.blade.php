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
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Support Ticket</span>
                                    </div>
                                     <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('articleType')}}">
                                                    <button class="btn btn-success"> Article Type</button> 
                                                </a>
                                            </div>
                                        </div> 
                                     
                                </div>
                                  
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="{{url('admin/supportTicket')}}" method="get" id="filter_data">
                                             
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('articleType') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                        </div>
                                    </div>
                                      
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th> Sno. </th>
                                                <th> Support Type </th>
                                                <th> Subject </th>
                                                <th> Email </th> 
                                                <th>Ticket ID</th>
                                                <th> Status </th> 
                                                <th>Created date</th> 
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($results as $key => $result)
                                            <tr>
                                                <td> {{++$key}} </td>
                                                <td> 

                                                    <a href="{{url('admin/articleType?search='.$result->supportType->resolution_department)}}" style="text-transform: capitalize;"> 
                                                    {{$result->supportType->resolution_department or 'NA'}} 
                                                    </a>
                                                 </td>
                                                 <td>
                                                    {{$result->subject}}
                                                 </td>
                                                <td>  {{$result->email}} </td>

                                                <td> <a class="btn-circle btn btn-success" href="{{url('admin/supportTicket?view=true&ticketId='.$result->ticket_id)}}"> #{{$result->ticket_id}} </a> </td> 
                                            	<td>  {{$result->status}} </td>
                                                 <td>
                                                    {!! Carbon\Carbon::parse($result->created_at)->format('m-d-Y'); !!}
                                                </td>
                                                
                                                <td> 
                                                     
                                                    <div class="btn-group dropup">
                                                                   
                                                                    <button type="button" class="btn green dropdown-toggle btn green-haze btn-outline btn-circle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                                        Action <i class="fa fa-angle-up"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu pull-right" role="menu">
                                                                         <li>
                                                                            <a href="javascript:;">
                                                                            	Action
                                                                              </a>
                                                                        </li>
                                                                             <li class="divider"> </li>
                                                                   
                                                                        <li>
                                                                            <a href="{{url('admin/supportTicket?view=true&status=inprogress=&ticketId='.$result->ticket_id)}}"> Inprogress </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{url('admin/supportTicket?view=true&status=reopen=&ticketId='.$result->ticket_id)}}"> Reopen </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{url('admin/supportTicket?view=true&status=resolved=&ticketId='.$result->ticket_id)}}"> resolved </a>
                                                                        </li>
                                                                        <li class="divider"> </li>
                                                                        <li> 
                                                                        	 <a href="{{url('admin/supportTicket?view=true&ticketId='.$result->ticket_id)}}">
                                                                        	View Details
                                                                        </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                    	</td>
                                               
                                            		</tr>
                                           @endforeach
                                            
                                        </tbody>
                                    </table>
                                     <div class="center" align="center">  {!! $results->appends(['search' =>isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            
            
            <!-- END QUICK SIDEBAR -->
        </div>
           
@stop

