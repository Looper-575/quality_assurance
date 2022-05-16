@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                    <h6 class="m-portlet__head-text">Employee Suspension form</h6>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Form-->
            <form id="suspension_form" action="javascript:save_suspension_details()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                @csrf
                <input type="hidden" name="suspension_id" id="suspension_id" value="{{isset($suspension) ? $suspension->suspension_id : 0}}">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <span class="font-bold font-14" for="user_id">Employee Name</span>
                            <select class="form-control" name="user_id" id="user_id" required >
                                <option value="">Select</option>
                                @foreach($users as $user)
                                    <option {{ (isset($suspension) && $suspension->user_id == $user->user_id)  ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6"></div>
                    <div class="col-6">
                        <div class="form-group">
                            <span class="font-bold font-14" for="from_date"> From Date</span>
                            <input  class="form-control" name="from_date" id="from_date" value="{{isset($suspension) ? $suspension->from_date : get_date()}}" type="date">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <span class="font-bold font-14" for="to_date"> To Date</span>
                            <input  class="form-control" name="to_date" id="to_date" value="{{isset($suspension) ? $suspension->to_date : ''}}" type="date">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <span class="font-bold font-14" for="reason"> Reason</span>
                            <textarea class="form-control" name="reason" id="reason" rows="3" style="width: 100%; max-width: 100%;">{{isset($suspension) ? $suspension->reason : ''}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-12 text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <button class="btn btn-danger" type="reset">Reset</button>
                        </div>
                    </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script>
        function save_suspension_details(){
            let data = new FormData($('#suspension_form')[0]);
            let a = function() {
                window.location.href = "{{route('employee_suspension')}}";
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('suspension_save')}}', data, arr);
        }
    </script>
@endsection