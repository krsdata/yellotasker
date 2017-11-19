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
                        <div style="" class="input-group"> 
                            <a href="<?php echo e(route('contact.create')); ?>">
                                <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Contact</button> 
                            </a>
                        </div>

                </div> 
                <div class="col-md-2 pull-right">
                    <div style="" class="input-group"> 
                        <a href="<?php echo e(route('contact')); ?>">
                            <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Group</button> 
                        </a>
                    </div> 
                </div>
                 <div class="col-md-3 pull-right">
                    <div style="" class="input-group"> 
                        <a href="<?php echo e(url::to('admin/contactGroup?export=pdf')); ?>">
                            <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Export Groups to pdf</button> 
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
                        <form action="<?php echo e(route('contactGroup')); ?>" method="get" id="filter_data">
                         
                            <div class="col-md-3">
                                <input value="<?php echo e((isset($_REQUEST['search']))?$_REQUEST['search']:''); ?>" placeholder="Search by group name" type="text" name="search" id="search" class="form-control" >
                            </div>
                            <div class="col-md-2">
                                <input type="submit" value="Search" class="btn btn-primary form-control">
                            </div>
                       
                        </form>
                        <div class="col-md-2">
                             <a href="<?php echo e(route('contactGroup')); ?>">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                        </div>
                       
                    </div>
                </div>  
            </div>
            <div class="portlet box  portlet-fit bordered"> 
                <div class="portlet-body"> 
                 
                    <?php foreach($contactGroup as $key => $result): ?> 
                    <?php $i = ++$key; ?>
                    <div class="panel-group accordion" id="accordion<?php echo e($i); ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="padding: 10px"> 
                           

                             <?php echo Form::open(array('class' => 'form-inline pull-right deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('contactGroup.destroy', $result->id))); ?>

                                <button class='delbtn btn btn-danger btn-xs pull-right' type="submit" name="remove_levels" value="delete" id="<?php echo e($result->id); ?>" style="padding: 2px">
                                <i class="fa fa-fw fa-trash" title="Delete"></i>
                                </button> 
                                <?php echo Form::close(); ?>  

                                 <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo e($i); ?>" href="#collapse_<?php echo e($i); ?>" aria-expanded="false"> 
                            <?php echo e(ucfirst($result->groupName)); ?> </a>  

                             <a  class="red  pull-right red-outline sbold" data-toggle="modal" href="#responsive_<?php echo e($result->id); ?>" id="<?php echo e(ucfirst($result->groupName)); ?>"  style="margin-right: 10px; "> 
                                <i class="fa fa-plus-circle"></i> 
                            Add or Edit </a> 
                                

                            </div>
                            <div id="collapse_<?php echo e($i); ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <table class="table table-striped table-hover table-bordered" id=""> 
                                        <thead>
                                            <tr>
                                                <th>Sno</th>
                                                <th> Name </th>
                                                <th> Email </th> 
                                                <th> Position </th> 
                                                 <th> Phone </th> 
                                                <th>Created date</th> 
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                    <tbody>
                                        <?php foreach($result->contactGroup as $key => $contact): ?>
                                            <?php if(isset($contact->contact)): ?>
                                            <tr>
                                                <td><?php echo e(++$key); ?></td>
                                                <td> <?php echo e($contact->contact->firstName.' '.$contact->contact->lastName); ?> </td>
                                                <td> <?php echo e($contact->contact->email); ?> </td>
                                                <td> <?php echo e($contact->contact->position); ?> </td>
                                                <td> <?php echo e($contact->contact->phone); ?> </td>
                                                <td>
                                                    <?php echo Carbon\Carbon::parse($contact->created_at)->format('Y-m-d');; ?>

                                                </td>
                                                <td> 
                                                       <!--  <a href="<?php echo e(route('contactGroup.edit',$result->id)); ?>">
                                                            <i class="fa fa-edit" title="edit"></i> 
                                                        </a> -->

                                                    <?php echo Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$contact->id, 'route' => array('contactGroup.destroy', $contact->id))); ?>

                                                    <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="<?php echo e($contact->id); ?>"><i class="fa fa-fw fa-trash" title="Delete"></i></button> 
                                                    <?php echo Form::close(); ?>

                                                </td> 
                                            </tr>
                                            <?php endif; ?>
                                           <?php endforeach; ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div> 
                    <?php endforeach; ?>
                </div>
             <div class="center" align="center">  
             <?php echo e($contactGroupPag->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render()); ?></div>
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



<?php foreach($contactGroup as $key => $result): ?>

<form id="updateGroup_<?php echo e($result->id); ?>" action="" method="post" encytype="multipart/form-data">
<input type="hidden" name="parent_id" value="<?php echo e($result->id); ?>" id="parent_id">
 <div id="responsive_<?php echo e($result->id); ?>" class="modal fade" tabindex="-1" data-width="300"  style="height: 500px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #efeb10 !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Update Contact Group</h4>
            </div>
            <div class="modal-body" style="overflow-y:scroll">
                <?php $data = $helper->contactName($result->id);  ?>
                <?php echo $data; ?> 
            </div>
            <div class="modal-footer">
                 <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                <button type="button" class="btn red" id="save"  onclick="updateGroup('<?php echo e(url("admin/updateGroup")); ?>',<?php echo e($result->id); ?>)" >Update</button>
            </div>
        </div>
    </div>
</div>
</form>
<?php endforeach; ?>