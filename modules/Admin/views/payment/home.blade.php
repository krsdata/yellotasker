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
                                                <th>Amount</th>
                                                <th>Service Charge</th>
                                                 <th>Net Amount</th>
                                                <th>Doer Id</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr ng-repeat='task in list'>
                                              <td><% task.id %> </td>
                                              <td><% task.title %> </td>
                                              <td>$<% task.totalAmount %> </td>
                                              <td>$<% task.totalAmount*0.10 %> </td>
                                              <td>$<% task.totalAmount-task.totalAmount*0.10 %> </td>
                                              <td><% task.taskDoerId %> </td>
                                              <td><button class="btn btn-primary btn-md"  ng-click="releaseFund(task.id,task.userId,task.taskDoerId,task.totalAmount-task.totalAmount*0.10)">Release Fund</button></td>
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


     <div id="responsive" class="modal fade" tabindex="-1" data-width="300">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Contact Group</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Contact Group Name</h4>
                        <p>
                            <input type="text" class="col-md-12 form-control" name="contact_group" id="contact_group"> </p>
                            <input type="hidden" name="contacts_id" value="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <span id="error_msg"></span>
                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                <button type="button" class="btn red" id="csave"  onclick="createGroup('{{url("admin/createGroup")}}','save')" >Save</button>
            </div>
        </div>
    </div>
</div>
</div>
