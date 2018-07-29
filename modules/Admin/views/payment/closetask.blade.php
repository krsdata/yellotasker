@extends('packages::layouts.master')
@section('title', 'Dashboard')
  @section('header')
@stop
@section('content')

@include('packages::partials.navigation')
<!-- Left side column. contains the logo and sidebar -->
@include('packages::partials.sidebar')

<div class="container" ng-app="paymentApp" ng-controller="paymentController">
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
                                <div ng-if="showReleaseFundList" class="portlet-body">
                                    <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                 <th>Task Id</th>
                                                <th>Task Title</th>
                                                <th>Task Amount</th>
                                                <th>Offer Amount</th>
                                                <th>Service Charge</th>
                                                 <th>Payable Amount</th>
                                                <th>Doer Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr ng-repeat='task in list'>
                                              <td><a href="<% currDomain %>/admin/postTask/<% task.id %>"><% task.id %></a></td>
                                              <td><% task.title %> </td>
                                              <td>MYR <% task.totalAmount %> </td>
                                              <td>MYR <% task.offer_details[0].offerPrice %> </td>
                                              <td>MYR <% task.offer_details[0].offerPrice*(task.offer_details[0].serviceCharges/100) %> </td>
                                              <td>MYR <% task.offer_details[0].offerPrice-task.offer_details[0].offerPrice*(task.offer_details[0].serviceCharges/100) %> </td>
                                              <td><a href="<% currDomain %>/admin/mytask/<% task.taskDoerId %>"><% task.taskDoerId %></a></td>
                                              <td><button class="btn btn-primary btn-md"  ng-click="sendWithrawalReq(task.id,task.userId,task.taskDoerId,task.totalAmount-task.totalAmount*0.10)">Close Task</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <span>

                                </div>
                                <div ng-if="!showReleaseFundList" >
                                  No list found
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

</div>
@stop
