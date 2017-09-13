
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
 
        <!-- Main content -->
         <!-- Small boxes (Stat box) -->
              <div class="row">
                  <div class="col-md-12">
                     <div class="portlet light portlet-fit portlet-form bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Update Profile</span>
                                    </div>
                                    
                                </div>



                       <div class="panel panel-cascade">
                          <div class="panel-body ">
                              
                              @if($flash_alert_notice)
                                   <div class="alert alert-success   bg-olive btn-flat margin alert-dismissable" style="margin:10px">
                                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <i class="icon fa fa-check"></i>  
                                      {{ $flash_alert_notice }}
                                   </div>
                              @endif


                               @if($error_msg)
                                   <div class="alert alert-danger  alert-dismissable" style="margin:10px">
                                      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                      <ul>
                                         @foreach ( $error_msg as $key => $value)  
                                         <li>        {{ $value }} </li>
                                         @endforeach 
                                      </ul> 
                                   </div>
                              @endif
                                      
                                <div class="row"> 
                                <div class="col-md-2"></div>   
                                  <div class="col-md-8"> 
                                    <form method="post" style="margin-top:30px;">
                                      @include('packages::users.admin.form', compact('users'))
                                    </form>
                                    
                                  </div>
                                </div>
                              </fieldset>  
                          </div>
                    </div>
                    </div>
                </div>            
              </div>  
            <!-- Main row --> 
          </section><!-- /.content -->
      </div> 
     <style type="text/css">
       .form-group{
          float: left;
          width: 100%;
       }  
     </style> 
@stop 