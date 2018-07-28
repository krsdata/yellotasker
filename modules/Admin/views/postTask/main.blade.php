@extends('packages::layouts.master')
  @section('title', 'Dashboard')
    @section('header')
    <h1>Dashboard</h1>
    @stop
    @section('content') 
      @include('packages::partials.navigation')
      <!-- Left side column. contains the logo and sidebar -->
      @include('packages::partials.sidebar')
       <!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
  <div class="page-content"> 
<!-- BEGIN PAGE BREADCRUMB -->
    @include('packages::partials.breadcrumb') 
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="row">
      <div class="col-md-12">  
        <div class="todo-content">
          <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
              <div class="col-md-6">
                 <div class="todo-taskbody-user">
                      <div class="col-md-3"> @if(!empty($postTasks->user->profile_image))
                       <img src="{{$postTasks->user->profile_image}}" width="80%" alt="">
                      @else
                       <img src="{{url('storage/image/poster-big.png')}}" alt="">
                      @endif
                      <h4>{{$postTasks->user->first_name or 'NA'}} 

                    </div>
                      
                      <div class="col-md-8">
                      
                      </h4>
                      <p>Email :{{$postTasks->user->email or 'NA'}} <br>
                        Post Date : <b>{{$taskPostDate}}</b> <br>
                        Due  Date : <b>{{$taskdueDate}}</b> <br>
                      
                         Status  <a href="javascript:;">
                                  <span class="badge badge-info"> {{$postTasks->status}}  </span> </a>
                      <a href="{{URL::previous() }}" class="btn">Go back</a>
                    </p>
                    </div>

                      
                  </div>
              </div>

              <ul class="nav nav-tabs">
                 
                <li class="active">
                    <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Posted Task</a>
                </li>
                <li class="">
                    <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">Poster Details</a>
                </li>
                <li class="">
                    <a href="#tab_1_3" data-toggle="tab" aria-expanded="false">Doer Details</a>
                </li>
                <li>
                    <a href="#tab_1_4" data-toggle="tab"> Offer details</a>
                </li>
                <li>
                    <a href="#comment" data-toggle="tab"> Comments</a>
                </li>
              </ul>
            </div>
            
            <div class="caption">
                          Task Title: 
                          <span class="caption-subject font-green bold uppercase">{{$postTasks->title}}
                          </span>
                      </div> 
            <div class="portlet-body">
              <div class="tab-content"> 
                <div class="tab-pane active" id="tab_1_1"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Posted Task
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                            @if(isset($postTasks) and ($postTasks->count())>0)
                      <table class="table table-striped table-hover table-bordered" id="">
                        
                          <thead>
                             @foreach($table_cname as $key => $result)
                             @if($result=="id" || $result=='title')
                             <?php continue; ?>
                             @endif 
                              <tr>
                               
                                  <th>{{ ucfirst(str_replace('_',' ',snake_case($result))) }}</th>
                                  <th>{{ $postTasks->$result}}
                                    @if($result=='totalAmount' ||
                                        $result=='hourlyRate')
                                      {!! $currency->field_value or 'MYR' !!}
                                    @endif
                                   </th>
                                
                              </tr>
                              @endforeach
                          </thead>
                          <tbody>
                     
                          </tbody>
                         
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div> 
                <div class="tab-pane " id="tab_1_2"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Poster details
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                            @if(isset($posterUser))
                      <table class="table table-striped table-hover table-bordered" id="">
                          <thead> 
                             @foreach($posterUser as $key => $result)
                             <tr>
                             @if($key=="id" || $key=='updated_at')
                             <?php continue; ?>
                             @endif
                                <th>{{ ucfirst(str_replace('_',' ',snake_case($key))) }}</th>
                                  <th>{{ $result}} </th>
                              </tr>
                              @endforeach
                          </thead> 
                         
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div>
                <div class="tab-pane " id="tab_1_3"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Doer Details
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                            @if(isset($doer))
                      <table class="table table-striped table-hover table-bordered" id="">
                           <thead> 
                             @foreach($doer as $key => $result)
                             <tr>
                             @if($key=="id" || $key=='updated_at')
                             <?php continue; ?>
                             @endif
                                <th>{{ ucfirst(str_replace('_',' ',snake_case($key))) }}</th>
                                  <th>{{ $result}} </th>
                              </tr>
                              @endforeach
                          </thead> 
                         
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div> 
                <div class="tab-pane " id="tab_1_4"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Offer Details
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                      @if(isset($offers) and ($offers->count())>0)
                      <table class="table table-striped table-hover table-bordered" id="">
                          <thead>
                              <tr>
                                  <th>Sno</th>
                                  <th>Task Title </th>
                                  <th>Interested User </th>  
                                  <th>Offer Price</th>  
                                  <th>CompletionDate</th> 
                                  <th>Service Charges</th> 
                                  <th>Offer Date</th> 
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($offers as $key => $result)
                              <tr>
                                  <td>{{ ++$key}}</td>
                                  <td>{{$postTasks->title}} </td>
                                  <td> {{$result->interestedPeope->first_name}} {{$result->interestedPeope->last_name}} </td>  
                                  <td> {{$result->offerPrice}}  </td>  
                                  <td> {{$result->completionDate}} </td> 
                                  <td> {{$result->serviceCharges}} </td> 
                                  <td> {{$result->created_at}} </td> 
                              </tr>
                              @endforeach
                          </tbody>
                          
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div>
                <div class="tab-pane " id="comment"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Comments
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                            @if(isset($comments) and ($comments->count())>0)
                      <table class="table table-striped table-hover table-bordered" id="">
                          <thead>
                              <tr>
                                  <th>Sno</th>
                                  <th>User Name</th>   
                                  <th>commentDescription</th> 
                                  <th> Date</th>    
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($comments as $key => $result)
                              <tr>
                                  <td>{{ ++$key}}</td>
                                   
                                  <td> {{$result->userDetail->first_name}} {{$result->userDetail->last_name}} </td>  
                                  <td> {{$result->commentDescription}}  </td>  
                                  <td> {{$result->created_at}} </td> 
                              </tr>
                              @endforeach
                          </tbody>
                         
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div>  
              </div>  
            </div>

          </div>            
        </div> 
      </div>  
    </div>
  </div>
</div>

@stop