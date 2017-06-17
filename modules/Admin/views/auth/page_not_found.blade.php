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
               <div class="row">
                    <div class="box">
                        @if(Session::has('flash_alert_notice'))
                            <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <i class="icon fa fa-check"></i>  
                                    {{ Session::get('flash_alert_notice') }} 
                            </div>
                        @endif 
                        <div class="box-body table-responsive no-padding "  >
                           <div class="col-md-12">
                                 <div class="alert alert-default alert-dismissable">
                                 <h1> <i class="fa fa-warning text-yellow"></i>  <span style="color:#f39c12">  {{ $error_msg or 'Oops! The page you requested  was found.' }} </span></h1>
                            </div>
                            <div class="col-md-12 ">
                            </div>
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
<style>
  .btn.btn-block.btn-primary {
margin-bottom: 3px;
}
</style>
@stop
