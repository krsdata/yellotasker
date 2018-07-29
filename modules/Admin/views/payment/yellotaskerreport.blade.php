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
                           <h1>Yellotasker Report
                               <small>Profit,Net Outgoing and Net Incoming</small>
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
                           <span class="active">Yellotasker Report</span>
                       </li>
                   </ul>
                   <!-- END PAGE BREADCRUMB -->
                   <!-- BEGIN PAGE BASE CONTENT -->
                   <div class="row">
                         <div class="col-md-3">
                        <input type="text" id="startdate" ng-model="date" class="form-control taskdate" data-required="1" size="16" data-date-format="yyyy-mm-dd" name="startDate" placeholder="Start Date" ></input>
                          </div>
                        <div class="col-md-3">
                        <input type="text" id="enddate" ng-model="endDate" class="form-control taskdate" data-required="1" size="16" data-date-format="yyyy-mm-dd" name="endDate"  placeholder="End Date" ></input>
                        </div>
                       <button class="btn btn-primary btn-md user-report"  ng-click="getYellotaskerData()">Search</button>
                       <div ng-if="showError">Please enter dates</div>
                   </div>
                   <div class="row">
                     <div layout-gt-xs="row">

                       <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                           <div class="dashboard-stat2 bordered">
                               <div class="display">
                                   <div class="number">
                                       <h3 class="font-purple-soft">
                                           <span data-counter="counterup" data-value="276"><% yelloProfit %></span>
                                       </h3>
                                       <small>Profit (service charge earned considered as profit)</small>
                                   </div>
                                   <div class="icon">
                                       <i class="icon-user"></i>
                                   </div>
                               </div>
                               <div class="progress-info">
                                   <div class="progress">
                                       <span style="width: 57%;" class="progress-bar progress-bar-success purple-soft">
                                           <span class="sr-only">56% change</span>
                                       </span>
                                   </div>

                               </div>
                           </div>
                       </div>

                       <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                           <div class="dashboard-stat2 bordered">
                               <div class="display">
                                   <div class="number">
                                       <h3 class="font-blue-sharp">
                                           <span data-counter="counterup" data-value="567"><% yelloSpend %></span>
                                       </h3>
                                       <small>Net Outgoing</small>
                                   </div>
                                   <div class="icon">
                                       <i class="fa fa-folder-open-o"></i>
                                   </div>
                               </div>
                               <div class="progress-info">
                                   <div class="progress">
                                       <span style="width: 45%;" class="progress-bar progress-bar-success blue-sharp">
                                           <span class="sr-only">45% grow</span>
                                       </span>
                                   </div>

                               </div>
                           </div>
                       </div>

                       <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                           <div class="dashboard-stat2 bordered">
                               <div class="display">
                                   <div class="number">
                                       <h3 class="font-blue-sharp">
                                           <span data-counter="counterup" data-value="567"><% yelloEarn %></span>
                                       </h3>
                                       <small>Net Incoming</small>
                                   </div>
                                   <div class="icon">
                                       <i class="fa fa-folder-open-o"></i>
                                   </div>
                               </div>
                               <div class="progress-info">
                                   <div class="progress">
                                       <span style="width: 45%;" class="progress-bar progress-bar-success blue-sharp">
                                           <span class="sr-only">45% grow</span>
                                       </span>
                                   </div>

                               </div>
                           </div>
                       </div>
                   </div>
                   <!-- END PAGE BASE CONTENT -->
               </div>
               <div class="row">
                                   <div class="card-profile">
                     <ul class="nav nav-tabs" role="tablist">
                       <li ng-class="appliedActiveClass()" role="presentation" >
                         <a ng-click="showYelloTaskList('outgoing')">Outgoing</a>
                        </li>
                        <li ng-class="appliedClass()" role="presentation" >
                          <a ng-click="showYelloTaskList('incoming')">Incoming</a>
                         </li>
                     </ul>
                  <div  ng-if = "showYelloList">
                  <div class="portlet-body">
                     <table class="table table-striped table-hover table-bordered" id="contact">
                         <thead>
                             <tr>
                                  <th>Task Id</th>
                                 <th>Task Title</th>
                                 <!-- <th>Order Id</th> -->
                                 <th>Transaction Date</th>
                                 <th>Total Amount</th>
                                 <!-- <th>Doer Name</th> -->
                             </tr>
                         </thead>
                         <tbody>
                           <tr ng-if = "yelloOutgoingIndicator" ng-repeat='task in yelloOutgoing'>
                               <td><a href="<% currDomain %>/admin/postTask/<% task.id %>"><% task.id %></a></td>
                               <td><% task.title %> </td>
                               <!-- <td><% task.order_id %> </td> -->
                               <td><% task.updated_at %> </td>
                               <td>MYR <% task.totalAmount %> </td>
                               <!-- <td>Mehul Ahir</td> -->
                             </tr>
                             <tr ng-if = "yelloIncomingIndicator" ng-repeat='task in yelloIncome'>
                                 <td><a href="<% currDomain %>/admin/postTask/<% task.id %>"><% task.id %></a></td>
                                 <td><% task.title %> </td>
                                 <!-- <td><% task.order_id %> </td> -->
                                 <td><% task.updated_at %> </td>
                                 <td>MYR <% task.totalAmount %> </td>
                                 <!-- <td>Mehul Ahir</td> -->
                               </tr>
                         </tbody>
                     </table>
                     <span>
                  </div>
                  </div>
                  <div class="no-list" ng-if = "!showYelloList">
                   No list found
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
