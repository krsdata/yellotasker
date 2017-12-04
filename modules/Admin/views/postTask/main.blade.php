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
                    <span class="caption-subject font-red sbold uppercase">{{ $heading }}</span>
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
                    <div class="row"> 

                        <div class="modal-body">
            <div class="post-detail-left">
                <div class="detail-pic-name">
                    <div class="pic-name-left">
                        <img src="{{url('storage/image/poster-big.png')}}" alt="">
                    </div>
                    <div class="pic-name-right"> 

                        <h4>{{$postTasks->user->first_name or 'NA'}}<span class="follow-ico"><a href="#">
                        <img src="{{url('storage/image/follow.png')}}"></a></span>

                        </h4>
                        <p>{{$postTasks->user->email or 'NA'}} {{$postTasks->user->phone or ''}}</p>
                        <p><a href="#">
                            <img src="{{url('storage/image/open.png')}}">

                        </a> &nbsp;&nbsp;<a href="#"><img src="{{url('storage/image/assigned.png')}}"></a> &nbsp;&nbsp;<a href="#"><img src="{{url('storage/image/complete.png')}}"></a></p>
                    </div>
                </div>
                <div class="post-description">
                    <h4>Description</h4>
                    <p>
                     <b>{{$postTasks->title}}</b>
                    </p>
                   
                    <table class="table table-striped table-hover table-bordered" id="">
                        <tr>
                            <td width="200px">Title</td>
                            <td>{{$postTasks->title}}</td>
                        </tr>
                          <tr>
                            <td>Description</td>
                            <td>{{$postTasks->description}}</td>
                        </tr>
                          <tr>
                            <td>Location Type</td>
                            <td>{{$postTasks->locationType or 'NA'}}</td>
                        </tr>
                          <tr>
                            <td>Type Of People</td>
                            <td>{{$postTasks->typeOfPeople or 'NA'}}</td>
                        </tr>
                          <tr>
                            <td>Total Amount</td>
                            <td>{{$postTasks->totalAmount or 'NA'}}</td>
                        </tr>
                          <tr>
                            <td>People Required</td>
                            <td>{{$postTasks->peopleRequired or 'NA'}}</td>
                        </tr>
                         <tr>
                            <td>Budget</td>
                            <td>{{$postTasks->budget or 'NA'}}</td>
                        </tr>
                         <tr>
                            <td>Budget Type</td>
                            <td>{{$postTasks->budgetType or 'NA'}}</td>
                        </tr>
                         <tr>
                            <td>Status</td>
                            <td>{{$postTasks->status or 'NA'}}</td>
                        </tr>

                    </table>


                    <br>
                    <h4>Requirement</h4>
                    <p>{{$postTasks->title}}</p>
                    <p>
                        <img src="{{url('storage/image/map.jpg')}}" alt="" width="100%;">
                    </p>

                    <div><b>Comments :</b></div>
                    <div >
                        
                        @foreach($comments as $key => $result)
                            @if(!empty($result->commentDescription))
                            <p class="comment"><b>{{ !empty($result->userDetail->first_name)?$result->userDetail->first_name:'xyz'}} </b>: {{$result->commentDescription}} </p>
                            @endif
                        @endforeach
                         <style type="text/css">
                            p.comment{
                                  border: 1px solid #ccc;
                                padding: 10px;
                                border-radius: 5px !important;

                            }   
                              

                           </style>      

                    </div>
                </div>
            </div>
                        <div class="post-detail-right">
                            <h4>Task Budget</h4>
                            <div class="rate">
                                <p class="main-price">
                                            ${{$postTasks->totalAmount}}
                                            <span>Approx. {{$postTasks->totalHours}}Hrs</span>
                                </p>
                                <p class="make-offer">
                                            
                                </p>
                            </div>
                                <div class="popup-location">
                                    <div class="pop-location-nav">
                                        <i class="fa fa-location-arrow"></i>
                                    </div>
                                    <div class="pop-location-desc">
                                        <h5>{{$postTasks->address or 'NA'}}</h5>
                                        <p>
                                            
                                            {{$postTasks->zipcode}}
                                        </p>
                                    </div>
                                    
                                </div>
                                <div class="popup-location">
                                    <div class="pop-location-nav">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="pop-location-desc">
                                        <h5>Posted by {{$postBy}}</h5>
                                        <p>{{$postTasks->address}} <br>{{$postTasks->zipcode}}
                                        </p>
                                    </div>
                                    
                                </div>
                                <div class="offers-pop">
                                    
                                </div>
                            </div>
                      </div>
                           

                    
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