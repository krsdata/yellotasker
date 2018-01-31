
            <style type="text/css">
                table {
                        border-collapse: collapse;
                    }

                    table, th, td {
                        border: 1px solid black;
                        padding-left: 5px;
                    }
            </style>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
             <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD--> 
                    <h3> <center>YelloTasker</center></h3>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">People Of Contacts</span>
                                    </div>
                                        <hr>
                                         
                                     
                                </div>
                                  
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                         
                                    </div>
                                     
                                    <table class="table table-striped table-hover table-bordered" id="contact" style="width: 100%" border="1px" >
                                        <thead>
                                            <tr>
                                             <th> Sno</th>
                                             <th> Title </th>
                                                <th> Name </th>
                                                <th> Email </th> 
                                                <th> Phone </th> 
                                                <th>Position</th> 
                                                <th>Created date</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($contacts as $key => $result)
                                            <tr>
                                             <th> {{++$key}}</th>
                                             <td> {{$result->title }} </td>
                                                <td> {{$result->firstName.' '.$result->lastName}} </td>
                                                 <td> {{$result->email}} </td>
                                                 <td> {{$result->phone}} </td> 
                                                  <td> {{(isset($result->position) && !empty($result->position))?$result->position:'NA'}} </td> 
                                                     <td>
                                                        {!! Carbon\Carbon::parse($result->created_at)->format('m/d/Y'); !!}
                                                    </td>
                                                    
                                                     
                                               
                                            </tr>
                                           @endforeach
                                            
                                        </tbody>
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
        
    