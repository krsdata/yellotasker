
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
                                        <span class="caption-subject font-red sbold uppercase"><?php echo e(isset($heading) ? $heading : ''); ?></span>
                                    </div>
                                     
                                </div>
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="<?php echo e(route('user')); ?>" method="get" id="filter_data">
                                            <div class="col-md-3">
                                                <select name="status" class="form-control" onChange="SortByStatus('filter_data')">
                                                    <option value="">Sort by Status</option>
                                                    <option value="active" <?php if($status==='active'): ?> selected  <?php endif; ?>>Active</option>
                                                    <option value="inActive" <?php if($status==='inActive'): ?> selected  <?php endif; ?>>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input value="<?php echo e((isset($_REQUEST['search']))?$_REQUEST['search']:''); ?>" placeholder="search by Name/Email" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="<?php echo e(route('user')); ?>">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="<?php echo e(route('user.create')); ?>">
                                                    <button class="btn  btn-primary"><i class="fa fa-user-plus"></i> Add User</button> 
                                                </a>
                                            </div>
                                        </div> 
                                        </div>
                                    </div>
                                     
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                 <th> Sno. </th>
                                                <th> Name </th>
                                                <th> Email </th>
                                                <th> Phone </th>
                                                <th> Role </th>
                                                <th>Signup Date</th>
                                                <th>Status</th>
                                                <th>Action</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($users as $key => $result): ?>
                                            <tr>
                                                 <td> <?php echo e(++$key); ?> </td>
                                                <td> <?php echo e($result->name); ?> </td>
                                                <td> <?php echo e($result->email); ?> </td>
                                                <td> <?php echo e($result->phone); ?> </td>
                                                <td class="center">  <?php if($result->role_type==1): ?>
                                                    Admin
                                                    <?php elseif($result->role_type==2): ?>
                                                    Business
                                                    <?php else: ?>
                                                    Superadmin
                                                    <?php endif; ?></td>
                                                     <td>
                                                        <?php echo Carbon\Carbon::parse($result->created_at)->format('Y-m-d');; ?>

                                                    </td>
                                                    <td>
                                                        <span class="label label-<?php echo e(($result->status==1)?'success':'warning'); ?> status" id="<?php echo e($result->id); ?>"  data="<?php echo e($result->status); ?>"  onclick="changeStatus(<?php echo e($result->id); ?>,'user')" >
                                                            <?php echo e(($result->status==1)?'Active':'Inactive'); ?>

                                                        </span>
                                                    </td>
                                                    <td> 
                                                        <a href="<?php echo e(route('user.edit',$result->id)); ?>">
                                                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i> 
                                                        </a>

                                                        <?php echo Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('user.destroy', $result->id))); ?>

                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="<?php echo e($result->id); ?>"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        
                                                         <?php echo Form::close(); ?>


                                                    </td>
                                               
                                            </tr>
                                           <?php endforeach; ?>
                                            
                                        </tbody>
                                    </table>
                                     <div class="center" align="center">  <?php echo $users->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render(); ?></div>
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

        <script type="text/javascript">
            
            function SortByStatus(filter_data) {
                $('#filter_data').submit();
            }
        </script>
        