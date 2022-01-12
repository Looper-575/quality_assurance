@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Create Holiday</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="holiday_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="from">Title</label>
                            <input class="form-control" type="text" name="title" id="title" value="" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="type">Type</label>
                            <select class="form-control select2" name="type" id="type" required>
                                <option value="">Select Type </option>
                                <option value="Muslim">Muslim </option>
                                <option value="Christian">Christian </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="date_from" >Date From</label>
                            <input class="form-control" type="date" name="date_from" value="" id="date_from" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="date_to" >Date To</label>
                            <input class="form-control" type="date" name="date_to" value="" id="date_to" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit"  class="btn btn-primary float-right"> Create</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        //form submission;
        $('#holiday_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            let a = function(){
                window.location.reload();
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('save_holiday')}}',data,arr);
        });
    </script>
@endsection


