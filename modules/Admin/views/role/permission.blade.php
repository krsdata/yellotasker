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
                                        <span class="caption-subject font-red sbold uppercase">Permission</span>
                                    </div>
                                        <div class="col-md-2 pull-right">
                                            <div class="input-group"> 
                                                <button type="submit" form="permission-form" class="btn btn-success">Update Permission</button> 
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
       
                                    </div>
                                    <form action="{{url('admin/permission')}}" method="post" id="permission-form">
                                    <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Permission</th> 
                                                 @foreach($roles as $role )
                                                 <th colspan="3" class="text-center">{{$role->name }} </th>
                                                  @endforeach
                                              
                                            </tr>
                                             <tr>
                                                <th class="text-center">Permission</th> 
                                                 @foreach($roles as $role )
                                                 <th class="text-center"> Read</th>
                                                  <th class="text-center"> Write</th>
                                                   <th class="text-center"> Delete</th>
                                                  @endforeach
                                              
                                            </tr> 
                                           
                                        </thead>
                                        <tbody>
                                            
                                            
                                             @foreach($controllers as $route )
                                             <tr>
                                                 <td>{{$route}}</td>
                                               @foreach($roles as $role )
                                               <?php $permission =json_decode($role->permission); 
                                               $canRead = isset($permission->{$route}->read)?true:false;
                                               $canWrite = isset($permission->{$route}->write)?true:false;
                                               $canDelete = isset($permission->{$route}->delete)?true:false;
                                               ?>
                                               <td class="text-center"> 
                                                   <input type="checkbox" name="permission[{{$role->id}}][{{$route}}][read]" value="1"   @if($canRead)  checked="checked" @endif >
                                               </td>  
                                               <td class="text-center"> <input type="checkbox" name="permission[{{$role->id}}][{{$route}}][write]" value="1"  @if($canWrite)  checked="checked" @endif>
                                               </td> 
                                               <td class="text-center">  <input type="checkbox" name="permission[{{$role->id}}][{{$route}}][delete]" value="1"  @if($canDelete)  checked="checked" @endif>
                                               </td>
                                                  @endforeach
                                           </tr>     
                                              @endforeach
                                        </tbody>
                                    </table> 
                                    <div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
          {!! Form::submit(' Update Permission ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


           <a href="{{route('role')}}">
{!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>
                                    </form>
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

           