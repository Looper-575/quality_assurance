@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">leave Application form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data" method="post" id="transfer_form" action="{{route('transfer_save')}}">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group ">
                            <label class="form-check-label" for="sale_date">Sale Date </label>
                            <input  required  type="date"  class="form-control" name="sale_date" id="sale_date" >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group ">
                            <label class="form-check-label" for="sales_list"> Sales List </label>
                            <input  required  type="date"  class="form-control" name="sales_list" id="sales_list" >
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group ">
                                <label class="form-check-label" for="transfer_to">Transfer To </label>
                                <input  required  type="date"  class="form-control" name="transfer_to" id="transfer_to" >
                            </div>
                        </div>
                    </div>

                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary"> Submit </button>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>

@endsection
