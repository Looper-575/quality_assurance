@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div id="emp_separation_form"  class="m-portlet m-portlet--mobile p-3">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label> Employee Name: </label>
                        <span>{{ $suspension->user->full_name }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label> Effective From: </label>
                        <span>{{ $suspension->from_date }}</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label> Effective Till: </label>
                        <span>{{ $suspension->to_date }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label> Reason: </label>
                        <span>{{ $suspension->reason }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
@endsection