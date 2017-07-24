
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
                                     @if(Session::has('flash_alert_danger'))
                                         <div class="alert alert-danger alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_danger') }} 
                                         </div>
                                    @endif
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="{{route('category-dashboard')}}" method="get" id="filter_data">
                                             
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="Search by group name" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('category-dashboard') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                        </div>
                                    </div> 
                                    {!! Form::model($category, ['route' => ['category-dashboard.store'],'class'=>'','id'=>'user-form','enctype'=>'multipart/form-data']) !!}
                                  
                                     <table class="table table-striped  table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th> Category </th>
                                                <th>  Move  Category </th> 
                                                <th> Set Default Category </th> 
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                                <td>  
                                            <div class="form-group">
                                             @foreach ($categories as $key => $value) 
                                                  <label><b>{{ ucfirst($value->category_group_name)}}</b></label>
                                                  <ul>
                                                 @foreach ($sub_categories as $key => $value2)  
                                                    @if($value2->parent_id==$value->id) 
                                                    <div class="">
                                                        <label title="@if(in_array($value2->id,$cat_id)) Already moved @endif " class="mt-checkbox mt-checkbox-outline" style="@if(in_array($value2->id,$cat_id)) color:red; @endif">  
                                                            {{ucfirst($value2->category_name)}}
                                                            <input type="checkbox" value="{{$value2->id.'_'.$value2->category_name}}" name="name[{{$value->id}}][]" 
                                                            @if(in_array($value2->id,$cat_id)) disabled @endif >
                                                            <span></span>
                                                        </label> 
                                                    </div>

                                                    @endif
                                                @endforeach
                                                </ul>
                                            @endforeach
                                            
 

                                            </td>
                                            <td> <div style="width: 150px;" class="input-group"> 
                                                
                                                    <button class="btn btn-success" type="submit">
                                                    Move Right <i class="fa fa-arrow-right"></i> </button 
                                                </a>
                                            </div>

                                            </td>
                                                <td>  <ol>
                                                @if($categoryDashboard->count()==0)
                                                Default category not found!
                                                @endif
                                                @foreach ($categoryDashboard as $value)
                                                 <li>{{ ucfirst($value->name)}}  
                                                    
                                                     <a href="#" id="{{$value->id}}" onclick="popupAlert('{{ route('category-dashboard.destroy',$value->id)}}',{{$value->id}})">
                                                           <i class="fa fa-remove"></i>  
                                                        </a>
                                                </li>
                                                 @endforeach
                                                 </ol></td> 
                                            </tr> 
                                            
                                        </tbody>
                                    </table>
                                  
                                  {!! Form::close() !!}   
                                   
                                    
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
        