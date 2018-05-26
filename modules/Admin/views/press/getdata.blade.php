
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
                                                <a href="{{ URL::previous()}}">
                                                    <button class="btn btn-success"><i class="fa fa-long-arrow-left"></i> Go Back</button> 
                                                </a>

                                            </div>
                                        </div> 

                                     
                                </div>
                                  
                                    
                                <div class="portlet-body">
                                     
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th> Article title </th>  <td> {{ ucfirst($result->article_title)}} </td></tr>
                                             <tr>
                                                <th> Article type</th>  <td> {!!$result->articleCategory->article_type or 'NA'!!}  </td>
                                            </tr> 
                                            
                                            <tr>
                                                <th> Description</th> <td>  {!!$result->description!!}  </td>
                                            </tr>

                                            <tr>
                                                <th> Created date </th> <td>  {!! Carbon\Carbon::parse($result->created_at)->format('m-d-Y'); !!}</td>
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
        