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


                       <div class="panel panel-cascade">
                          <div class="panel-body ">
                              <fieldset><legend>Personel Information:</legend>

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



