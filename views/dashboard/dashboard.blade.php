@extends('layouts.master')
@section('content')

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="">
                        <a href="#">
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                        </a>
                    </li>
                    @if (Auth::user()->role_name=='Admin')
                        <li class="menu-title"> <span>Authentication</span> </li>
                    @endif
                    <li class="">
                        <a class="active" href="{{ route('form/training/list/page') }}"> Assign Project </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list2/page') }}"> Daily Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list3/page') }}"> Monthly Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('training/list4/page') }}"> Final Report </a>
                    </li>
                    <li class="">
                        <a class="active" href="{{ route('notes') }}"> Log Book </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Sidebar -->

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome !</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                            <div class="dash-widget-info">
                                <h3>112</h3> <span>Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                            <div class="dash-widget-info">
                                <h3>44</h3> <span>Students</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
        </div>
        <!-- /Page Content -->
    </div>
@endsection
