
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
                                        <span class="caption-subject font-red sbold uppercase">{{ $page_title }}</span>
                                    </div>
                                     <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('sub-category')}}">
                                                    <button class="btn btn-success"><i class="fa fa-long-arrow-left"></i> Go Back</button> 
                                                </a>

                                            </div>
                                        </div> 

                                     
                                </div>
                                  
                                    
                                <div class="portlet-body">
                                     
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th> Category Name </th>  <td> {{$result->category_name}} </td></tr>
                                             <tr>
                                                <th> Group Name</th>  <th> {{$result->category_group_name}}  </th></tr> 
                                               <tr>
                                                <th> Image </th> <th>  <a href="{{ url::asset('storage/uploads/category/'.$result->category_group_image)  }}" target="_blank" >

                                                <img src="{{ url::asset('storage/uploads/category/'.$result->category_group_image)  }}" width="100px" height="50px;"> </a></th></tr>
                                                <tr>
                                                <th> Created date </th> <th>  {!! Carbon\Carbon::parse($result->created_at)->format('Y-m-d'); !!}</th></tr> 
                                                <tr>
                                                <th> Description</th> <th>  {{$result->description}}  </th></tr>
                                                 <tr>  
                                            </tr>
                                        </thead>
                                       
                                    </table>
                                     
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
        