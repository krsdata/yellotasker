
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
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('blog.create')}}">
                                                    <button  class="btn btn-success"><i class="fa fa-plus-circle"></i> Create Blog</button> 
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
                                            <form action="{{route('blog')}}" method="get" id="filter_data">
                                             
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search " type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('blog') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                        </div>
                                    </div>
                                     
                                    <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                <th>Sno</th> 
                                                    <th>Blog Title</th>
                                                    <th>Blog description</th>
                                                     <th>Blog type</th>
                                                    <th>image </th> 
                                                    <th>Created Date</th> 
                                                    <th>Action</th>
                                            </tr>
                                              @if(count($blog )==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          {{ 'Record not found. Try again !' }}
                                                        </div>
                                                      </td>
                                                    </tr>
                                                  @endif
                                               
                                        </thead>
                                        <tbody>
                                         @foreach ($blog  as $key => $result)  
                                            <tr>
                                               <td>{{ ++$key }}</td>
                                                    <td>{!! ucfirst($result->blog_title)     !!}

                                                    </td>
                                                   
                                                    <td>{!! substr(strip_tags($result->blog_description),0,50) !!}...<a href="{{ route('blog.show',$result->id)}}">
                                                            <i class="glyphicon glyphicon-eye-open" title="view"></i> 
                                                        </a>
                                                    </td>

                                                    <td>{!! ucfirst($result->blog_type) !!} </td>

                                                    <td>
                                                      <!--   {!!  substr(html_entity_decode($result->description, ENT_QUOTES, 'UTF-8'),0,50)  !!}.. -->
                                                      @if(file_exists(storage_path('blog/'.$result->blog_image)) && $result->blog_image!=null)
                                                      <img src="{{url('storage/blog/'.$result->blog_image)}}" width="100px"> 
                                                      @else
                                                       NA
                                                      @endif
                                                     </td>
                                                     <td>
                                                        {!! Carbon\Carbon::parse($result->created_at)->format('d-M-Y'); !!}
                                                    </td>
                                                    
                                                    <td> 
                                                        <a href="{{ route('blog.edit',$result->id)}}">
                                                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i> 
                                                        </a>

                                                        {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('blog.destroy', $result->id))) !!}
                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        
                                                         {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                                @endforeach 
                                            
                                        </tbody>
                                    </table>
                                    <span>
                                     
                                     <div class="center" align="center">  {!! $blog->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
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