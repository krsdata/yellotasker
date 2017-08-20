@extends('packages::layouts.master')
@section('content') 
@include('packages::partials.main-header')
<!-- Left side column. contains the logo and sidebar -->
@include('packages::partials.main-sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    @include('packages::partials.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-cascade">
                        <div class="panel-body ">
                            <div class="row">
                                <div class="box">
                                    <div class="box-header">
                                        <form action="{{route('user')}}" method="get">
                                            <div class="col-md-3">
                                                <select name="status" class="form-control">
                                                    <option value="">Sort by Status</option>
                                                    <option value="active" @if($status==='active') selected  @endif>Active</option>
                                                    <option value="inActive" @if($status==='inActive') selected  @endif>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search by Name/Email" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('user') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('user.create')}}">
                                                    <button class="btn  btn-primary"><i class="fa fa-user-plus"></i> Add User</button> 
                                                </a>
                                            </div>
                                        </div> 
                                    </div><!-- /.box-header -->

                                    
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                      
                                   <div class="box-body table-responsive no-padding" >
                                        <table class="table table-hover table-condensed">
                                            <thead><tr>
                                                    <th>Sno</th>
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>  
                                                    <th>Signup Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                @if(count($users)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          {{ 'Record not found. Try again !' }}
                                                        </div>
                                                      </td>
                                                    </tr>
                                                  @endif
                                                @foreach ($users as $key => $user)  
                                             <thead>
                                              <tbody>    
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td> 
                                                    @if($user->role_type==1)
                                                    Admin
                                                    @elseif($user->role_type==2)
                                                    Business
                                                    @else
                                                    Superadmin
                                                    @endif
                                                    
                                                    </td> 
                                                    <td>
                                                        {!! Carbon\Carbon::parse($user->created_at)->format('m-d-Y H:i:s A'); !!}
                                                    </td>
                                                    <td>
                                                        <span class="label label-{{ ($user->status==1)?'success':'warning'}} status" id="{{$user->id}}"  data="{{$user->status}}"  onclick="changeStatus({{$user->id}},'user')" >
                                                            {{ ($user->status==1)?'Active':'Inactive'}}
                                                        </span>
                                                    </td>
                                                    <td> 
                                                        <a href="{{ route('user.edit',$user->id)}}">
                                                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i> 
                                                        </a>

                                                        {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$user->id, 'route' => array('user.destroy', $user->id))) !!}
                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$user->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        
                                                         {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                                @endforeach 
                                            </tbody></table>
                                    </div><!-- /.box-body --> 
                                    <div class="center" align="center">  {!! $users->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div> 
        <!-- Main row --> 
    </section><!-- /.content -->
</div> 

@stop
