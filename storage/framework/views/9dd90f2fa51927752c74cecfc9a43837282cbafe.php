
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
             <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                   <?php echo $__env->make('packages::partials.breadcrumb', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase"><?php echo e($heading); ?></span>
                                    </div>
                                     <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="<?php echo e(route('program.create')); ?>">
                                                    <button  class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Program</button> 
                                                </a>
                                            </div>
                                        </div> 
                                     
                                </div>
                                  
                                    <?php if(Session::has('flash_alert_notice')): ?>
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         <?php echo e(Session::get('flash_alert_notice')); ?> 
                                         </div>
                                    <?php endif; ?>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="<?php echo e(route('program')); ?>" method="get" id="filter_data">
                                             
                                            <div class="col-md-3">
                                                <input value="<?php echo e((isset($_REQUEST['search']))?$_REQUEST['search']:''); ?>" placeholder="Search " type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="<?php echo e(route('program')); ?>">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                        </div>
                                    </div>
                                     
                                    <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                 <th>Sno.</th>
                                                <th> Program Name </th>
                                                <th> Start Date </th> 
                                                <th> End Date </th> 
                                                 <th>   </th> 
                                                <th>Created date</th> 
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($programs as $key => $result): ?>
                                            <tr>
                                             <th>  <?php echo e(++$key); ?> </th>
                                                <td> <?php echo e($result->program_name); ?> </td>
                                                 <td> <?php echo e($result->start_date); ?> </td>
                                                 <td> <?php echo e($result->end_date); ?> </td>
                                                    <td>  <a href="<?php echo e(route('program.show',$result->id)); ?>">
                                                            <i class="fa fa-eye" title="details"></i> 
                                                        </a>View Details </td> 
                                                     <td>
                                                        <?php echo Carbon\Carbon::parse($result->created_at)->format('Y-m-d');; ?>

                                                    </td>
                                                    
                                                    <td> 
                                                        <a href="<?php echo e(route('program.edit',$result->id)); ?>">
                                                            <i class="fa fa-edit" title="edit"></i> 
                                                        </a>

                                                        <?php echo Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('program.destroy', $result->id))); ?>

                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="<?php echo e($result->id); ?>"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        
                                                         <?php echo Form::close(); ?>


                                                    </td>
                                               
                                            </tr>
                                           <?php endforeach; ?>
                                            
                                        </tbody>
                                    </table>
                                    <span>
                                     
                                     <div class="center" align="center">  <?php echo $programs->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render(); ?></div>
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
                <button type="button" class="btn red" id="csave"  onclick="createGroup('<?php echo e(url("admin/createGroup")); ?>','save')" >Save</button>
            </div>
        </div>
    </div>
</div>