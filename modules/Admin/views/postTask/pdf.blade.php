
            <style type="text/css">
                table {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    table, th, td {
                        border: 1px solid black;
                        padding-left: 5px;
                    }
            </style>
             <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    <center><h3>Yellotasker</h3></center>
                    <!-- END PAGE HEAD--> 

                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                <div class="row">
                    <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET--> 
                        <div class="portlet light portlet-fit bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-red"></i>
                                    <span class="caption-subject font-red sbold uppercase">{{ $heading }} List</span>
                                </div>
                                <hr>
                            </div>
                                  
                           
                            <div class="portlet box  portlet-fit bordered"> 
                                <div class="portlet-body"> 
                                 
                                    @foreach($contactGroup as $key => $result) 
                                    <?php $i = ++$key; ?>
                                    <div class="panel-group accordion" id="accordion{{$i}}">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">

                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{{$i}}" href="#collapse_{{$i}}" aria-expanded="false"> 
                                                    {{ $result->groupName}} </a> 

                                                </h4>
                                            </div>
                                            <div id="collapse_{{$i}}" class="panel-collapse collapse">
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
                                                            </tr>
                                                        </thead>
                                                    <tbody>
                                                        @foreach($result->contactGroup as $key => $contact)
                                                            @if(isset($contact->contact))
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td> {{$contact->contact->firstName.' '.$contact->contact->lastName}} </td>
                                                                <td> {{$contact->contact->email}} </td>
                                                                <td> {{$contact->contact->position}} </td>
                                                                <td> {{$contact->contact->phone}} </td>
                                                                <td>
                                                                    {!! Carbon\Carbon::parse($contact->created_at)->format('Y-m-d'); !!}
                                                                </td>
                                                                
                                                            </tr>
                                                            @endif
                                                           @endforeach 
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> 
                                    </div> 
                                    @endforeach
                                </div>
                             <div class="center" align="center">  
                             {{ $contactGroupPag->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() }}</div>
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
        