@extends('packages::layouts.master') 
    @section('content') 
      @include('packages::partials.main-header')
      <!-- Left side column. contains the logo and sidebar -->
      @include('packages::partials.main-sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper"> 
        <section class="content-header">
          <h1>
            Admin
            <small>Create</small>
              </h1>
              <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><a href="#">Admin</a></li>
                <li class="active">create</li>
              </ol>
        </section>

        <!-- Main content -->
          <section class="content">
            <!-- Small boxes (Stat box) -->
              <div class="row">

                  <div class="col-md-12">
                    
                       <div class="panel panel-cascade">
                          <div class="panel-body ">
                              <div class="row">
                                  <div class="box-header">
                                    <div class="box-tools">
                                      <div style="width: 150px;" class="input-group"> 
                                          <a href="{{ route('group')}}">
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-group"></i> View  Group</button> 
                                          </a>
                                      </div>
                                    </div>
                                  </div><!-- /.box-header -->
                                  <div class="col-md-9">
                                      {!! Form::model($admin, ['route' => ['admin.store'],'class'=>'form-horizontal','id'=>'admin']) !!}
                                          @include('packages::users.admin.form')
                                      {!! Form::close() !!}
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
