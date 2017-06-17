@extends('packages::layouts.master')
  @section('title', 'Dashboard')
    @section('header')
    <h1>Dashboard</h1>
    @stop
    @section('content') 
      @include('packages::partials.main-header')
      <!-- Left side column. contains the logo and sidebar -->
      @include('packages::partials.main-sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <section style="margin:15px 30px -30px 30px">
        @if(Input::has('error'))
                 <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                 <h4> <i class="icon fa fa-check"></i>  
                    Sorry! You are trying to access invalid URL. <a href="{{url('admin')}}"> Reset</a></h4>

                 </div>
            @endif
       <hr>  
      </section>
        @if(!Input::has('error'))
          <!-- Main content -->
          <section class="content">
            <!-- Small boxes (Stat box) -->                      
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>{{ $professor}}</h3>
                    <p>Registered Professor</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="{{route('professor')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div><!-- ./col -->
              
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                  <div class="inner">
                    <h3>{{ $student}}</h3>
                    <p>Registered Student</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{route('student')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div><!-- ./col -->


               <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                  <div class="inner">
                    <h3>{{ $course }}</h3>
                    <p>Total Course</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{url('admin/course')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div><!-- ./col -->


                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                  <div class="inner">
                      <h3>{{ $assignment }}</h3>
                    <p>Total Assigments</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{url('admin/assignment')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                  <div class="inner">
                      <h3>{{ $syllabus }}</h3>
                    <p>Total Syllabus</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{url('admin/syllabus')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div><!-- ./col -->


            </div><!-- /.row -->
            <!-- Main row -->  
          </section>
        @endif 
      </div><!-- /.content-wrapper -->
     

@stop
