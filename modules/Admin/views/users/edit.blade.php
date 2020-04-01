
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
                    
                      @include('packages::partials.breadcrumb')

                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet bordered">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic">
                                    @if(!empty($user->profile_image))
                                    
                                     <img src="{{$user->profile_image}}" class="img-responsive" alt=""> </div>
                                    @else
                                     <img src="{{ URL::asset('assets/img/user.png')}}" class="img-responsive" alt=""> </div>
                                    @endif
                                      
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name"> {{$user->first_name}} </div>
                                        <div class="profile-usertitle-job"> {{$user->position}} </div>
                                    </div>
                                    <!-- END SIDEBAR USER TITLE -->
                                    <!-- SIDEBAR BUTTONS -->
                                    <div class="profile-userbuttons">
                                        <button type="button" class="btn btn-circle green btn-sm">Email</button>
                                        <button type="button" class="btn btn-circle red btn-sm">Message</button>
                                      @if($user->role_type==3)
                                        <a href="{{url('admin/mytask/'.$user->id)}}">
                                         <button type="button" class="btn btn-circle green btn-sm">Task</button>
                                         </a>
                                         @endif
                                    </div>
                                    <!-- END SIDEBAR BUTTONS -->
                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li>
                                               <a href="{{url('admin/mytask/'.$user->id)}}">
                                                    <i class="icon-home"></i> Overview </a>
                                            </li>
                                            <li class="active">
                                                <a href="#">
                                                    <i class="icon-settings"></i> Account Settings </a>
                                            </li>
                                            <!-- <li>
                                                <a href="#">
                                                    <i class="icon-info"></i> Help </a>
                                            </li> -->
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                                <!-- PORTLET MAIN -->
                                <div class="portlet light bordered">
                                    <!-- STAT -->
                                   
                                    <!-- END STAT -->
                                    <div>
                                        <h4 class="profile-desc-title">About {{$user->first_name}}</h4>
                                          <div class="row list-separated profile-stat">
                                      <!--   <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 37 </div>
                                            <div class="uppercase profile-stat-text"> Projects </div>
                                        </div> -->
                                        <!-- <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 0 </div>
                                            <div class="uppercase profile-stat-text"> Tasks </div>
                                        </div> -->
                                      <!--   <div class="col-md-4 col-sm-4 col-xs-6">
                                            <div class="uppercase profile-stat-title"> 61 </div>
                                            <div class="uppercase profile-stat-text"> Uploads </div>
                                        </div> -->
                                    </div>
                                        <span class="profile-desc-text">{{$user->about_me}}</span>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-phone"></i>
                                            {{$user->phone}}
                                        </div>
                                       <!--  <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-twitter"></i>
                                            <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-facebook"></i>
                                            <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_2" data-toggle="tab">Change Avatar</a>
                                                    </li>
                                                   
                                                    <!-- <li>
                                                        <a href="#tab_1_4" data-toggle="tab">  Payment Info</a>
                                                    </li> -->
                                                </ul>
                                            </div>
                                   {!! Form::model($user, ['method' => 'PATCH', 'route' => ['user.update', $user->id],'enctype'=>'multipart/form-data']) !!}
                                   <input type="hidden" name="role" value="{{$_REQUEST['role_type']}}"> 
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB --> 
                                                <div class="margin-top-10">
                                                    @if (count($errors) > 0)
                                                      <div class="alert alert-danger">
                                                          <ul>
                                                              @foreach ($errors->all() as $error)
                                                                  <li>{!! $error !!}</li>
                                                              @endforeach
                                                          </ul>
                                                      </div>
                                                    @endif
                                                </div>

                                            @include('packages::users.formTab1', compact('user'))

                                            {!! Form::close() !!} 
                                            <!-- END PERSONAL INFO TAB --> 
                                            @include('packages::users.formTab2', compact('user'))
                                            <!-- END CHANGE AVATAR TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <!-- END CHANGE PASSWORD TAB -->
                                            <!-- PRIVACY SETTINGS TAB --> 
                                            @include('packages::users.formTab4', compact('user')) 
                                            <!-- END PRIVACY SETTINGS TAB --> 

                                           
                                        </div>

                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            
            
            <!-- END QUICK SIDEBAR -->
        </div>
        

        
@stop