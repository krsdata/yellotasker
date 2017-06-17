<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/plugins/iCheck/square/blue.css') }}"> 
    <link rel="stylesheet" href="{{ URL::asset('public/assets/css/custom.css') }}"> 
    
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>{{ Lang::get('admin-lang.immoclick_Admin_panel') }}</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body"> 
        <p class="login-box-msg"> 
          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

          {!! Form::model($user, ['url' => ['admin/login'],'class'=>'form-horizontal','files' => true]) !!}
            @include('packages::auth.form')
          {!! Form::close() !!}

        
        <a href="{{ url('admin/forgot-password') }}">{{ Lang::get('admin-lang.i_forget_pwd') }}</a><br> 

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
      <script src="{{ URL::asset('public/assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
      <script src="{{ URL::asset('public/assets/js/jquery.validate.js') }}"></script>
      <!-- Bootstrap 3.3.5 -->
      <script src="{{ URL::asset('public/assets/bootstrap/js/bootstrap.min.js') }}"></script>
      <!-- iCheck -->
      <script src="{{ URL::asset('public/assets/plugins/iCheck/icheck.min.js') }}"></script>
       <script src="{{ URL::asset('public/assets/plugins/iCheck/datepicker.js') }}"></script>  
      <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
     <script src="{{ URL::asset('public/assets/js/common.js') }}"></script>
     <script type="text/javascript">
        var email_req = '{{ Lang::get('admin-lang.email_req') }}';
        var password_req = '{{ Lang::get('admin-lang.password_req') }}';
     </script>
  </body>
</html>
