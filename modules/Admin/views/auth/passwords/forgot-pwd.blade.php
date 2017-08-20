<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ Lang::get('immoclick-lang.immoclick_Admin_panel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/iCheck/square/blue.css') }}"> 
    <link rel="stylesheet" href="{{ URL::asset('assets/css/custom.css') }}"> 
    
  </head>
  <body class="hold-transition login-page">fdfdf
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>{{ Lang::get('immoclick-lang.immoclick') }}</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">

            <p class="login-box-msg">{{ Lang::get('immoclick-lang.forgot_password') }}</p> 
        {!!  Form::open(array('url' => 'admin/forgot-password', 'method' => 'post','id'=>'user_login')) !!}
          @include('packages::loginpage.forgetpwd-form')
               

        {!! Form::close() !!}  
        
       <a href="{{ url('admin/login') }}">{{ Lang::get('immoclick-lang.sign_in') }}</a><br> 
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
      <script src="{{ URL::asset('assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/jquery.validate.js') }}"></script>
      <!-- Bootstrap 3.3.5 -->
      <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
      <!-- iCheck -->
      <script src="{{ URL::asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
      <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
     <script src="{{ URL::asset('assets/js/common.js') }}"></script>
     <script type="text/javascript">
        var email_req = '{{ Lang::get('immoclick-lang.email_req') }}';
        var password_req = '{{ Lang::get('immoclick-lang.password_req') }}';
     </script>
  </body>
</html>
