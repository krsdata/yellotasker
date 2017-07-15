<section style="margin:15px 30px -30px 30px">
    @if(Input::has('error'))
         <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4> <i class="icon fa fa-check"></i>  
            Sorry! You are trying to access invalid URL.</h4>
         </div>
    @endif
</section>

<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{ url('/') }}">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ Route::currentRouteName()  }}">{{ $page_title  }}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active">{{ $page_action }}</span>
    </li>
</ul>