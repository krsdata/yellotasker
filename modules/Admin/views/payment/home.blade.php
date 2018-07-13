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
                                <div ng-if="showWithdrawalList" class="portlet-body">
                                    <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                 <th>Task Id</th>
                                                <th>Transaction Id</th>
                                                <th>Amount</th>
                                                <th>Service Charge</th>
                                                 <th>Payable Amount</th>
                                                <th>User Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr ng-repeat='task in withdrawallist'>
                                              <td><% task.id %> </td>
                                              <td><% task.txn_id %> </td>
                                              <td>MYR <% task.amount %> </td>
                                              <td>MYR <% task.service_charge %> </td>
                                              <td>MYR <% task.payable_amount %> </td>
                                              <td><% task.userId %> </td>
                                              <td><button class="btn btn-primary btn-md"  ng-click="releaseFund(task.id)">Release Fund</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <span>

                                </div>
                                <div ng-if="!showWithdrawalList" >
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
