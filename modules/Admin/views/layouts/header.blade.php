<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $page_title or 'Admin|dashboard' }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta http-equiv="refresh" content="900;url={{URL::to('logout')}}" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/bootstrap/css/bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ URL::asset('public/assets/css/custom.css') }} ">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/bootstrap/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/bootstrap/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/dist/css/skins/_all-skins.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/plugins/iCheck/flat/blue.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/plugins/morris/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/plugins/datepicker/datepicker3.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ URL::asset('public/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/assets/css/jquery-ui.css') }}" id="theme">
    <link rel="stylesheet" href="{{ URL::asset('public/assets/css/blueimp-gallery.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/assets/css/select2.min.css') }}">
  </head>
   <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">