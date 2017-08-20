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
                    <form action="{{route('systemAlertSearch')}}" method="get">    
                    <div class="col-md-3 pull-right">
                        <input value="{{ (isset($_REQUEST['search']))?$_REQUEST['search']:''}}" placeholder="search by Name/Email" type="text" name="search" id="search" class="form-control" >
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-danger btn-danger-input">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                  <!--   <div class="col-md-2">
                        <input type="submit" value="Search" class="btn btn-primary form-control">
                    </div> -->
                </form> 
                    
                </div><!-- /.box-header -->
                
                  
                @if(Session::has('flash_alert_notice'))
                  <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <i class="icon fa fa-check"></i>  
                     {{ Session::get('flash_alert_notice') }} 
                  </div>
                 @endif 
                
                <div class="box-body table-responsive no-padding "  >
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <th>  ID            </th>
                        <th>  Email         </th>
                        <th>  Disabled      </th>
                        <th>  Min Price     </th>
                        <th>  Max Price     </th> 
                        <th>  Created Date  </th>
                        <th>  Action        </th>
                      </tr>
                       @if(count($results)==0)
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
                      @foreach ($results as $key => $result)  
                      <tr>
                        <td>  {{ $result->id }}         </td>
                        <td>  {{ $result->Email }}      </td> 
                        <td>  {{ ($result->Disabled==1)?'Yes':'No' }}  </td>
                        <td>  {{ $result->Min_price }}  </td> 
                        <td>  {{ $result->Max_price }}  </td> 
                        <td>  {{ $result->created_at }} </td>
                        
                         
                        <td> 
                         <a href="{{ route('systemAlertSearch.edit',$result->id) }}">
                            <i class="fa fa-fw fa-pencil-square-o" title="edit"></i>
                        </a>   
                             {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('systemAlertSearch.destroy', $result->id))) !!}
                                <button class="delbtn" type="submit"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                            {!! Form::close() !!}  

     
                        </td>
                      </tr>
                     @endforeach 
                                      </tbody></table>
                                    </div><!-- /.box-body -->

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
      <style>
          .btn.btn-block.btn-primary {
  margin-bottom: 3px;
}
</style>
@stop
