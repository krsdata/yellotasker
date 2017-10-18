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
                                        <form action="{{route('criteria')}}" method="get">
                                            
                                            <div class="col-md-3">
                                                <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search criteria" type="text" name="search" id="search" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                        </form>
                                        <div class="col-md-2 pull-right">
                                            <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('criteria.create')}}">
                                                    <button class="btn  btn-primary"><i class="fa fa-user-plus"></i> Add Criteria</button> 
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
                                     
                                    <div class="box-body table-responsive no-padding">

                                        <table class="table table-hover">
                                            <tbody><tr>
                                                    <th>Sno</th>
                                                    <th>Criteria ID</th>
                                                    <th>Criteria </th>
                                                    <th>Created By</th>
                                                    <th>CompanyUrl</th>
                                                    <th>Created Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                @if(count($criteria)==0)
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
                                                @foreach ($criteria as $key => $result) 
                                                <tr>
                                                    <td>{{ ++$key }}</td> 
                                                    <td>{{ $result->id }}</td> 
                                                    <td>{{ $result->interview_criteria }}</td> 
                                                     <td>  
                                                        {{ isset($result->user->first_name)?$result->user->first_name:'Admin' }}
                                                    </td>
                                                    <td>
                                                          {{ 
                                                          isset($result->user->email)?$helper->getCompanyUrlByEmail($result->user->email):'Admin'
                                                          }}
                                                    </td>  
                                                    <td>{{ $result->created_at }}</td>
                                                     
                                                    <td> 
                                                        <a href="{{ route('criteria.edit',$result->id)}}">
                                                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i> 
                                                        </a> 
                                                        {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('criteria.destroy', $result->id))) !!}
                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        {!! Form::close() !!}

                                                    </td>
                                                </tr>
                                                @endforeach 
                                            </tbody></table>
                                    </div><!-- /.box-body -->
                                    
                                </div>
                                <div class="center" align="center"> 
                                        {{ $criteria->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() }}
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
