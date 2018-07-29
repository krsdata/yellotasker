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
                                    <div class="card-profile">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li ng-class="appliedActiveClassForRf()" role="presentation" >
                                        <a ng-click="changeList('sip')">SIP Generated</a>
                                        </li>
                                        <li ng-class="appliedClassForRf()" role="presentation" >
                                            <a ng-click="changeList('rf')">Release Funds</a>
                                        </li>
                                    </ul>
                                 </div>
                                <div ng-if="showWithdrawalList" class="portlet-body">
                                    <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                 <th>Withdrawal Id</th>
                                                <th>Transaction Id</th>
                                                <!-- <th>Amount</th>
                                                <th>Service Charge</th> -->
                                                 <th>Payable Amount</th>
                                                <th>User Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-if="sipListIndicator">
                                          <tr ng-repeat='task in withdrawallist'>
                                              <td ng-if="task.status==2"><% task.id %></td>
                                              <td ng-if="task.status==2"><% task.txn_id %> </td>
                                              <!-- <td ng-if="task.status==2">MYR <% task.amount %> </td>
                                              <td ng-if="task.status==2">MYR <% task.service_charge %> </td> -->
                                              <td ng-if="task.status==2">MYR <% task.payable_amount %> </td>
                                              <td ng-if="task.status==2"><a href="<% currDomain %>/admin/mytask/<% task.userId %>"><% task.userId %></a> </td>
                                              <td ng-if="task.status==2"><button class="btn btn-primary btn-md"  ng-click="releaseFund(task.id,task.api_response)"><% task.api_response!=null?'View Detail':' Release Fund' %></button></td>
                                            </tr>
                                        </tbody>
                                        <tbody ng-if="rfListIndicator">
                                          <tr ng-repeat='task in withdrawallist'>
                                              <td ng-if="task.status==1"><% task.id %></td>
                                              <td ng-if="task.status==1"><% task.txn_id %> </td>
                                              <!-- <td ng-if="task.status==1">MYR <% task.amount %> </td>
                                              <td ng-if="task.status==1">MYR <% task.service_charge %> </td> -->
                                              <td ng-if="task.status==1">MYR <% task.payable_amount %> </td>
                                              <td ng-if="task.status==1"><a href="<% currDomain %>/admin/mytask/<% task.userId %>"><% task.userId %></a> </td>
                                              <td ng-if="task.status==1"><button class="btn btn-primary btn-md"  ng-click="releaseFund(task.id,task.api_response)"><% task.api_response!=null?'View Detail':' Release Fund' %></button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <span>

                                </div>
                                <div ng-if="!showWithdrawalList" >
                                  No list found
                                </div>
                            </div>


                            <div class="row">
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
