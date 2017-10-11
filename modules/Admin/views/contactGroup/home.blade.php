
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
                                <div class="col-md-2 pull-right">
                                        <div style="" class="input-group"> 
                                            <a href="{{ route('contact.create')}}">
                                                <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Add Contact</button> 
                                            </a>
                                        </div>

                                </div> 
                                <div class="col-md-2 pull-right">
                                    <div style="" class="input-group"> 
                                        <a href="{{ route('contact')}}">
                                            <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Group</button> 
                                        </a>
                                    </div> 
                                </div>  
                            </div>
                                  
                            @if(Session::has('flash_alert_notice'))
                                 <div class="alert alert-success alert-dismissable" style="margin:10px">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                  <i class="icon fa fa-check"></i>  
                                 {{ Session::get('flash_alert_notice') }} 
                                 </div>
                            @endif
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <form action="{{route('contactGroup')}}" method="get" id="filter_data">
                                         
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search by group name" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                       
                                        </form>
                                        <div class="col-md-2">
                                             <a href="{{ route('contactGroup') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                    </div>
                                </div>  
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
                                                                <th>Action</th> 
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
                                                                <td> 
                                                                       <!--  <a href="{{ route('contactGroup.edit',$result->id)}}">
                                                                            <i class="fa fa-edit" title="edit"></i> 
                                                                        </a> -->

                                                                    {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$contact->id, 'route' => array('contactGroup.destroy', $contact->id))) !!}
                                                                    <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$contact->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button> 
                                                                    {!! Form::close()  !!}
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
        