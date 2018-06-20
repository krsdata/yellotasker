@extends('packages::layouts.master')
  @section('title', 'Dashboard')
    @section('header')
    <h1>Dashboard</h1>
    @stop
    @section('content') 
  	@include('packages::partials.navigation')
      <!-- Left side column. contains the logo and sidebar -->
  	@include('packages::partials.sidebar') 

	<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
		<div class="page-content">
		    @include('packages::partials.breadcrumb')
		  	<div class="row">
		        <div class="col-md-12">
		            <!-- BEGIN TODO SIDEBAR -->
		            <div class="todo-ui">
		                <div class="todo-sidebar">
		                    <div class="portlet light bordered">
		                        <div class="portlet-title">
		                            <div class="caption" data-toggle="collapse" data-target=".todo-project-list-content">
		                                <span class="caption-subject font-green-sharp bold uppercase">Tasks Report</span>
		                                <span class="caption-helper visible-sm-inline-block visible-xs-inline-block">click to view project list</span>
		                            </div>
		                            <div class="actions">
		                                <div class="btn-group">
		                                    <a class="btn green btn-circle btn-outline btn-sm todo-projects-config" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
		                                        <i class="icon-settings"></i> &nbsp;
		                                        <i class="fa fa-angle-down"></i>
		                                    </a>
		                                   <!--  <ul class="dropdown-menu pull-right">
		                                        <li>
		                                            <a href="javascript:;"> New Project </a>
		                                        </li>
		                                        <li class="divider"> </li>
		                                        <li>
		                                            <a href="javascript:;"> Pending
		                                                <span class="badge badge-danger"> 4 </span>
		                                            </a>
		                                        </li>
		                                        <li>
		                                            <a href="javascript:;"> Completed
		                                                <span class="badge badge-success"> 12 </span>
		                                            </a>
		                                        </li>
		                                        <li>
		                                            <a href="javascript:;"> Overdue
		                                                <span class="badge badge-warning"> 9 </span>
		                                            </a>
		                                        </li>
		                                        
		                                        <li>
		                                            <a href="javascript:;"> In progress </a>
		                                        </li>
		                                    </ul> -->
		                                </div>
		                            </div>
		                        </div>
		                        <div class="portlet-body todo-project-list-content" style="height: auto;">
		                            <div class="todo-project-list">
		                                <ul class="nav nav-stacked">
		                                    <li>
		                                        <a href="javascript:;">
		                                            <span class="badge badge-default">{{ ($postTasks->count())?$postTasks->count():0 }}</span> Posted Task</a>
		                                    </li>
		                                    <li>
		                                        <a href="javascript:;">
		                                            <span class="badge badge-info"> {{ ($inprogressTasks->count())?$inprogressTasks->count():0 }} </span> In Progress </a>
		                                    </li>
		                                    <li class="active">
		                                        <a href="javascript:;">
		                                            <span class="badge badge-success"> {{ ($completedTasks->count())?$completedTasks->count():0 }}</span> Completed</a>
		                                    </li>
		                                    <li>
		                                        <a href="javascript:;">
		                                            <span class="badge badge-danger">{{ ($expireTasks->count())?$expireTasks->count():0 }} </span> Overdue</a>
		                                    </li>
		                                   <!--  <li>
		                                        <a href="javascript:;">
		                                            <span class="badge badge-info"> 6 </span> Saved </a>
		                                    </li>
		                                    <li>
		                                        <a href="javascript:;">
		                                            <span class="badge badge-danger"> 2 </span> Offer </a>
		                                    </li> -->
		                                </ul>
		                            </div>
		                        </div>
		                    </div>
		                   
		                </div>
		                <!-- END TODO SIDEBAR -->
		                <!-- BEGIN TODO CONTENT -->
            <div class="todo-content">
             	<div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                           <div class="form-group">
                                <div class="col-md-8 col-sm-8">
                                    <div class="todo-taskbody-user">
                                        <img class="todo-userpic pull-left" src="{{ url('assets/img/user.png')}}" width="50px" height="50px">
                                        <span class="todo-username pull-left">{{ $user->first_name }}</span>
                                        <a href="{{URL::previous() }}" class="btn">Go back</a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <ul class="nav nav-tabs">
                        	 <li class="active">
                                <a href="#tab_1_0" data-toggle="tab" aria-expanded="true">Profile</a>
                            </li>
                            <li class="">
                                <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Posted Task</a>
                            </li>
                            <li class="">
                                <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">In Progress Task</a>
                            </li>
                            <li class="">
                                <a href="#tab_1_3" data-toggle="tab" aria-expanded="false">Complete Task</a>
                            </li>
                            <li>
                                <a href="#tab_1_4" data-toggle="tab">  Overdue Task</a>
                            </li>
                        </ul>
                    </div>

<div class="portlet-body">
    <div class="tab-content">
        <!-- PERSONAL INFO TAB -->  


	<div class="tab-pane active" id="tab_1_0"> 
		<div class="portlet light bordered">
	 		<div class="portlet-title">
	            <div class="caption">
	                <i class="icon-social-dribbble font-green"></i>
	                <span class="caption-subject font-green bold uppercase">User Info
	                </span>
	            </div> 
	        </div> 

		    <div class="form-group ">
		    	      @if(isset($userDetail))
			     <table class="table table-striped table-hover table-bordered" id="">
	                <thead>
	                @foreach($userDetail as $key => $result)
	                	<?php if( $key == "id" || $key=="created_at" || $key == "updated_at")
	                	{
	                		//continue;	
	                	}else{
	                	?>
	                    <tr>
	                    	<th> {{ ucfirst($key) }} </th>
	                        <th> {{ !empty($result)?$result:'NA' }} </th>
	                         
	                    </tr>
	                    <?php } ?>
                    @endforeach
	                </thead>
	                <tbody>
	          
	                 
	                </tbody>
	               
	            </table>
	            @else
	            No Record Found!
	             @endif
	     	</div>

	    
		</div>
	</div>



	<div class="tab-pane" id="tab_1_1"> 
		<div class="portlet light bordered">
	 		<div class="portlet-title">
	            <div class="caption">
	                <i class="icon-social-dribbble font-green"></i>
	                <span class="caption-subject font-green bold uppercase">Posted Task
	                </span>
	            </div> 
	        </div> 

		    <div class="form-group ">
		    	      @if(isset($postTasks) and ($postTasks->count())>0)
			     <table class="table table-striped table-hover table-bordered" id="">
	                <thead>
	                    <tr>
	                    	<th>Sno</th>
	                        <th>Task Title </th>
	                        <th>Description </th>  
	                        <th>Total Amount</th> 
	                        <th>Hourly Rate</th> 
                         	<th>Status</th> 
	                        <th>Created Date</th> 
                         	<th>Action</th>  
	                    </tr>
	                </thead>
	                <tbody>
	          
	                	@foreach($postTasks as $key => $result)
		                    <tr>
		                        <td>{{++$key}}</td>
		                        <td>{{ substr($result->title,0,15)   }}</td>
		                        <td>{{ substr($result->description,0,15)   }}</td>
		                        <td>{{ $result->totalAmount}}</td>
		                        <td>{{ $result->hourlyRate}}</td>
		                        <td>{{ $result->status}}</td>
		                        <td>{{ \Carbon\Carbon::parse($result->created_at)->format('M d,Y') }}</td>
		                        <td><a href="{{route('postTask.show',$result->id)}}"> View Details </a></td> 
		                    </tr>
	                    @endforeach 
	                </tbody>
	               
	            </table>
	            @else
	            No Record Found!
	             @endif
	     	</div>

	    
		</div>
	</div>
                                             
                                            <!-- END PERSONAL INFO TAB --> 
	<div class="tab-pane" id="tab_1_2">  
		<div class="portlet light bordered">
	 		<div class="portlet-title">
	            <div class="caption">
	                <i class="icon-social-dribbble font-green"></i>
	                <span class="caption-subject font-green bold uppercase">In Progress Task
	                </span>
	            </div> 
	        </div>
	  
	    
	         <div class="form-group">
	           	 @if(isset($inprogressTasks) and ($inprogressTasks->count()>0))
			     <table class="table table-striped table-hover table-bordered" id="">
	                <thead>
	                    <tr>
	                    	<th>Sno</th>
	                        <th>Task Title </th>
	                        <th>Description </th>  
	                        <th>Total Amount</th> 
	                        <th>Hourly Rate</th> 
                         	<th>Status</th> 
	                        <th>Created Date</th> 
                         	<th>Action</th>  
	                    </tr>
	                </thead>
	                <tbody>
	               
	                @foreach($inprogressTasks as $key => $result)
	                    <tr>
	                         <td>{{++$key}}</td>
	                        <td>{{ substr($result->title,0,15)   }}</td>
	                        <td>{{ substr($result->description,0,15)   }}</td>
	                        <td>{{ $result->totalAmount}}</td>
	                        <td>{{ $result->hourlyRate}}</td>
	                        <td>In Progress</td>
	                         <td>{{ \Carbon\Carbon::parse($result->created_at)->format('M d,Y') }}</td>
	                        <td><a href="{{route('postTask.show',$result->id)}}"> View Details </a></td>
	                       
	                    </tr>

	                   @endforeach 
	                </tbody>
	                
	            </table>
	             @else
	                    No record found!
                @endif

	        </div>

	            
	           <!--  </form> -->
	    </div> 
	</div>                                            <!-- END CHANGE AVATAR TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
	<div class="tab-pane" id="tab_1_3">
	    <div class="portlet light bordered">
	        <div class="portlet-title">
	            <div class="caption">
	                <i class="icon-social-dribbble font-green"></i>
	                <span class="caption-subject font-green bold uppercase">Complete Task
	                </span>
	            </div> 
	        </div>
	        
	            <div class="portlet-body">   

	                <div class="form-group"> 
	                 @if(isset($completedTasks) && ($completedTasks->count()>0))
                 	<table class="table table-striped table-hover table-bordered" id="">
	                <thead>
	                    <tr>
	                    <th> Sno</th>
	                        <th> Task Title </th>
	                        <th> Description </th>  
	                        <th>Total Amount</th> 
	                        <th>Hourly Rate</th> 
	                         <th>Status</th> 
	                        <th>Created Date</th> 
	                         <th>Action</th>  
	                    </tr>
	                </thead>
	                <tbody>
	               
	                @foreach($completedTasks as $key => $result)
	                    <tr>
	                        <td>{{++$key}}</td>
	                        <td>{{ substr($result->title,0,15)   }}</td>
	                        <td>{{ substr($result->description,0,15)   }}</td>
	                        <td>{{ $result->totalAmount}}</td>
	                        <td>{{ $result->hourlyRate}}</td>
	                        <td>Completed</td>
	                         <td>{{ \Carbon\Carbon::parse($result->created_at)->format('M d,Y') }}</td>
	                        <td><a href="{{route('postTask.show',$result->id)}}"> View Details </a></td>
	                       
	                    </tr>
	                   @endforeach 
	                </tbody>
	              
	            </table>
	            	@else
	            	No record found!
	              	@endif
	                </div>
	            </div>
	            
	  </div>
	</div>                                            <!-- END CHANGE PASSWORD TAB -->
                                            <!-- PRIVACY SETTINGS TAB --> 
	<div class="tab-pane" id="tab_1_4">
	                                                 
	        <div class="portlet light bordered">
	            <div class="portlet-title">
	                <div class="caption">
	                     <i class="icon-social-dribbble font-green"></i>
	                    <span class="caption-subject font-green-sharp bold uppercase">Overdue Task</span>
	                </div>
	               
	            </div>
	            <div class="portlet-body"> 
	               @if(isset($expireTasks) && ($expireTasks->count())>0)
	               <table class="table table-striped table-hover table-bordered" id="">
	                <thead>
	                    <tr>
	                    	<th>Sno</th>
	                        <th>Task Title </th>
	                        <th>Description </th>  
	                        <th>Total Amount</th> 
	                        <th>Hourly Rate</th> 
                         	<th>Status</th> 
	                        <th>Due Date</th> 
                         	<th>Action</th>  
	                    </tr>
	                </thead>
	                <tbody>
	               
	                @foreach($expireTasks as $key => $result)
	                    <tr>
	                        <td>{{++$key}}</td>
	                        <td>{{ substr($result->title,0,15)   }}</td>
	                        <td>{{ substr($result->description,0,15)   }}</td>
	                        <td>{{ $result->totalAmount}}</td>
	                        <td>{{ $result->hourlyRate}}</td>
	                        <td>Expired</td>
	                        <td>{{ \Carbon\Carbon::parse($result->created_at)->format('M d,Y') }}</td>
	                        <td><a href="{{route('postTask.show',$result->id)}}"> View Details </a></td>
	                       
	                    </tr>
	                   @endforeach 
	                </tbody>
	               
	            </table>
	            @else
	            No record found!
	             @endif
	            </div>
	        </div>   
	</div> 
                                            <!-- END PRIVACY SETTINGS TAB --> 

                                           
                                        </div>

                                    </div> 
                                    
                                </div>
		                </div>
		                <!-- END TODO CONTENT -->
		            </div>
		        </div> 
		    </div>
	    </div>
    </div>

@stop