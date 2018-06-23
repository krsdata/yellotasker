
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
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="{{route('compaint')}}" method="get" id="filter_data">
                                             <input type="hidden" name="reasonType" value="{{$_REQUEST['reasonType']}}">
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Ticket Id" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-3">
                                                {!! Form::text('taskdate',null, ['id'=>'taskdate','class' => 'form-control taskdate','data-required'=>1,"size"=>"16","data-date-format"=>"dd-mm-yyyy","placeholder"=>'Reported Date'])  !!} 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('compaint') }}?reasonType={{$_REQUEST['reasonType']}}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                        </div>
                                    </div>
                                     
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                 <th> Sno</th>
                                                 <th> Ticket ID</th>
                                               <!--  <th> Task Title </th> -->
                                                <th> Reported User </th>  
                                                <th> Comment </th> 
                                                <th> Reason Description </th>  
                                                 <th colspan="2"> Status </th>   
                                                 
                                                 <th>Reported Date</th> 
                                                 <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($comments as $key => $result)
                                        @if( isset($result->reportedUserDetail) && isset($result->taskDetail->id ))
                                            <tr>
                                             <td> {{ (($comments->currentpage()-1)*15)+(++$key) }}</td>
                                                 <td> 
                                                    

                                                       <a class="btn-circle btn btn-success" href="{{url('admin/comment/showComment/'.$result->taskDetail->id)}}"> #{{ $result->compainId }}    </a>

                                                    </td>
                                             <!--    <td> <a href="{{route('postTask.show',$result->taskDetail->id)}}"> {{ $result->taskDetail->title or 'na' }}</a></td> -->
                                                <td>  

                                                @if(isset($result->reportedUserDetail->first_name))
                                                <a href="{{url('admin/mytask/'.$result->reportedUserDetail->id)}}">
                                                    {{ $result->reportedUserDetail->first_name.' '. $result->reportedUserDetail->last_name }}
                                                    </a>
                                                @endif

                                               </td>
                                                <td>{{ $result->comment }}</td>
                                                <td>{{ $result->reason->reasonDescription or 'NA'}}</td>
                                              <td>
                                                    {{ $result->status }}
                                                   </td>  
                                               
                                               
                                                <td>
                                                     <div class="btn-group dropup">
                                                                   
                                                        <button type="button" class="btn green dropdown-toggle btn green-haze btn-outline btn-circle btn-sm" data-toggle="dropdown" aria-expanded="false">
                                                            change Status <i class="fa fa-angle-up"></i>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right" role="menu">
                                                            <li>
                                                                <a href="{{url('admin/supportTicket?view=true&status=inprogress&ticketId='.$result->ticket_id)}}"> Inprogress </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{url('admin/supportTicket?view=true&status=reopen&ticketId='.$result->ticket_id)}}"> Reopen </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{url('admin/supportTicket?view=true&status=resolved&ticketId='.$result->ticket_id)}}"> resolved </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{url('admin/supportTicket?view=true&status=resolved&ticketId='.$result->ticket_id)}}"> close </a>
                                                            </li>
                                                            <li class="divider"> </li>
                                                            <li> 
                                                                 <a href="{{url('dmin/comment/showComment/'.$result->taskDetail->id)}}">
                                                                View Details
                                                            </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td> 
                                                 <td> 
                                                    {!! Carbon\Carbon::parse($result->created_at)->format('d-m-Y'); !!}
                                                </td>
                                               <!--  <td><a href="{{url('admin/comment/showComment/'.$result->taskDetail->id)}}"> View Reply </a></td> -->
                                                <td> 
                                                    {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('comment.destroy', $result->id))) !!}
                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                    {!! Form::close() !!} 
                                                </td>
                                            </tr>
                                            @endif
                                           @endforeach 
                                        </tbody>
                                    </table>
                                    Showing {{($comments->currentpage()-1)*$comments->perpage()+1}} to {{$comments->currentpage()*$comments->perpage()}}
                                    of  {{$comments->total()}} entries

                                    <div class="center" align="center">  {!! $comments->appends(['search' => isset($_GET['search'])?$_GET['search']:'','reasonType'=>isset($_GET['reasonType'])?$_GET['reasonType']:''])->render() !!}</div>
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
       