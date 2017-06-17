@extends('packages::layouts.master')
@section('content') 
@include('packages::partials.main-header')
<!-- Left side column. contains the logo and sidebar -->
@include('packages::partials.main-sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    @include('packages::partials.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-cascade">
                        <div class="panel-body ">
                            <div class="row">
                                <div class="box">
                                    <div class="box-header">
                                        <form action="{{route('assignment')}}" method="get">
                                             
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="assignment title" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('assignment') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('assignment.create')}}">
                                                    <button class="btn  btn-primary"><i class="fa fa-user-plus"></i> Add assignment</button> 
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- /.box-header -->

                                    
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                      
                                   <div class="box-body table-responsive no-padding" >
                                        <table class="table table-hover table-condensed">
                                            <thead><tr>
                                                    <th>ID</th>
                                                    <th>Course </th> 
                                                    <th>Paper Title</th>  
                                                    <th>Duration</th>
                                                    <th>Chapter</th>
                                                    <th>Type</th>
                                                    <th>Grade</th>
                                                    <th>Due Date</th>
                                                    <th>Created Date</th> 
                                                    <th>Action</th>
                                                </tr>
                                                @if(count($assignment)==0)
                                                    <tr>
                                                      <td colspan="7">
                                                        <div class="alert alert-danger alert-dismissable">
                                                          <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                          <i class="icon fa fa-check"></i>  
                                                          {{ 'Record not found. Try again !' }}
                                                        </div>
                                                      </td>
                                                    </tr>
                                                  @endif
                                                  <?php $i=0; ?>
                                                @foreach ($assignment as $key => $result)  
                                                @if(isset($result->course->course_name))
                                             <thead>
                                              <tbody>    
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>{{ isset($result->course->course_name)?$result->course->course_name:'' }}</td>
                                                    <td>{{ $result->paper_title}}</td> 
                                                    <td>{{ $result->duration}}</td>
                                                    <td>{{ $result->chapter}} </td> 
                                                    <td>{{ $result->type}} </td> 
                                                    <td>{{ $result->grade}} </td> 
                                                    <td>{{ $result->due_date}} </td> 
                                                    <td>
                                                        {!! Carbon\Carbon::parse($result->created_at)->format('m/d/Y'); !!}
                                                    </td>
                                                   
                                                    <td> 
                                                        <a href="{{ route('assignment.edit',$result->id)}}">
                                                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i> 
                                                        </a>

                                                        {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('assignment.destroy', $result->id))) !!}
                                                            <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        
                                                        {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                                </tbody>
                                                 </thead>
                                                @endif
                                                @endforeach 
                                            </table>
                                    </div><!-- /.box-body --> 
                                    <div class="center" align="center">  {!! $assignment->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div> 
        <!-- Main row --> 
    </section><!-- /.content -->
</div> 

@stop
