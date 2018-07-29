@extends('packages::layouts.master')
@section('title', 'Dashboard')
  @section('header')
@stop
@section('content')

@include('packages::partials.navigation')
<!-- Left side column. contains the logo and sidebar -->
@include('packages::partials.sidebar')

<!-- END SIDEBAR -->
           <!-- BEGIN CONTENT -->
           <!-- BEGIN CONTENT -->
<div class="container" ng-app="paymentApp" ng-controller="paymentController">
           <div class="page-content-wrapper">
               <!-- BEGIN CONTENT BODY -->
               <div class="page-content">
                   <!-- BEGIN PAGE HEAD-->
                   <div class="page-head">
                       <!-- BEGIN PAGE TITLE -->
                       <div class="page-title">
                           <h1>Service Charge Configuration
                               <!-- <small>Profit,Net Outgoing and Net Incoming</small> -->
                           </h1>
                       </div>
                       <!-- END PAGE TITLE -->

                       <!-- END PAGE TOOLBAR -->
                   </div>
                   <!-- END PAGE HEAD-->
                   <!-- BEGIN PAGE BREADCRUMB -->
                   <ul class="page-breadcrumb breadcrumb">
                       <li>
                           Payment
                           <i class="fa fa-circle"></i>
                       </li>
                       <li>
                           <span class="active">Service Charge Configuration</span>
                       </li>
                   </ul>

                   <div class="row">
                       <div class="col-sm-12 change-current">
                       <label><b>Current service charge</b>: <% currentServiceCharge %> % of total task cost. (in MYR).</label>
                       <button class="btn change-btn btn-primary btn-md user-report"  ng-click="changeServiceCharge()">Change</button>
                       
                    </div>
                   </div>
                   <!-- END PAGE BREADCRUMB -->
                   <!-- BEGIN PAGE BASE CONTENT -->
                   <div class="row change-current new-service" ng-init="model = {}"  >
                       <div ng-if = "chngServiceChargeIndicator">
                   <label> New service charges </label>
                   <span style="float:left; width:100%; margin-bottom:10px;"><input class="search-input"  type='text' ng-model='model.serviceCharge'></span>
               <!-- <input class="search-input"  type='text' ng-model='serviceCharge'> -->
               <button class="btn change-btn btn-primary btn-md user-report"  ng-click="saveServiceCharge()">Save</button>
               <button class="btn btn-primary btn-md user-report"  ng-click="close()">Cancel</button>
               <p class="red-text" ng-if="serviceChargeError">Please enter valid value.</p>                
            </div>
                            
                                </div>
                               
               </div>
               
               <!-- END CONTENT BODY -->
           </div>
           <!-- END CONTENT -->
           <!-- END QUICK SIDEBAR -->
       </div>
     </div>
@stop
