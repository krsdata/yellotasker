@extends('packages::layouts.master')
  @section('title', 'Complain Management')
    @section('header')
    <h1>Complain Management</h1>
    @stop
    @section('content') 
      @include('packages::partials.navigation')
      <!-- Left side column. contains the logo and sidebar -->
      @include('packages::partials.sidebar')
      @include('packages::complains.home')   
@stop