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
                                        <span class="caption-subject font-red sbold uppercase">{{$heading or ''}}</span>
                                    </div>
                                     
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="{{route('user')}}" method="get" id="filter_data">
                                            <div class="col-md-2">
                                                <select name="status" class="form-control" onChange="SortByStatus('filter_data')">
                                                    <option value="">Search by Status</option>
                                                    <option value="active" @if($status==='active') selected  @endif>Active</option>
                                                    <option value="inActive" @if($status==='inActive') selected  @endif>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="role_type" class="form-control" onChange="SortByStatus('filter_data')">
                                                    <option value="">Search by Role</option>
                                                    @if($roles)
                                                        @foreach($roles as $role)
                                                            <option value="{{$role->id}}" @if($role_type==$role->id) selected @endif >{{$role->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search by Name/Email" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('clientuser') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('user.create')}}">
                                                    <button class="btn  btn-primary"><i class="fa fa-user-plus"></i> Add User</button> 
                                                </a>
                                            </div>
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
                                    @if($users->count()==0)
                                   
                                     <span class="caption-subject font-red sbold uppercase"> Record not found!</span>
                                    @else 
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                 <th> Sno. </th>
                                                <th> Full Name </th>
                                                <th> Email </th>
                                                <th> Phone </th>
                                                <th> {{($heading=='Admin Users')?'User Type':''}} </th>
                                                <th>Signup Date</th>
                                                <th>Status</th>
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>

                                    
                                        @foreach($users as $key => $result)
                                            <tr>
                                                 <td> {{ (($users->currentpage()-1)*15)+(++$key) }}</td>
                                                <td> {{$result->first_name.'  '.$result->last_name}} </td>
                                                <td> {{$result->email}} </td>
                                                <td> {{$result->phone}} </td>
                                                <td class="center"> 
                                               
                                                    @if($result->role_type==3)
                                                    <a href="{{url('admin/mytask/'.$result->id)}}">
                                                        View Details
                                                        <i class="glyphicon glyphicon-eye-open" title="edit"></i> 

                                                    </a>
                                                    @else
                                                      {{ ($result->role_type==1)?'admin':($result->role_type==2)?'Sales':($result->role_type==4)?'Support':'Admin'}}
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! Carbon\Carbon::parse($result->created_at)->format('Y-m-d'); !!}
                                                </td>
                                                <td>
                                                    <span class="label label-{{ ($result->status==1)?'success':'warning'}} status" id="{{$result->id}}"  data="{{$result->status}}"  onclick="changeStatus({{$result->id}},'user')" >
                                                            {{ ($result->status==1)?'Active':'Inactive'}}
                                                        </span>
                                                </td>
                                                <td> 
                                                    <a href="{{ route('user.edit',$result->id)}}?role_type={{$result->role_type}}">
                                                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i> 
                                                        </a>

                                                        {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('user.destroy', $result->id))) !!}
                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        
                                                         {!! Form::close() !!}

                                                    </td>
                                               
                                            </tr>
                                           @endforeach
                                         @endif   
                                        </tbody>
                                    </table>
                                    Showing {{($users->currentpage()-1)*$users->perpage()+1}} to {{$users->currentpage()*$users->perpage()}}
                                    of  {{$users->total()}} entries
                                     <div class="center" align="center">  {!! $users->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
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

        <script type="text/javascript">
            
            function SortByStatus(filter_data) {
                $('#filter_data').submit();
            }
        </script>
        
@stop