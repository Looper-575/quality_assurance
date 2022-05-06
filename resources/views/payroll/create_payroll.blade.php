@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <style>
       th{
            font-weight: bold !important;
        }
    </style>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Create Payroll</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="attendance_report_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label" for="year_month">Pay Month</label>
                            <input class="form-control mt-2" type="month" name="year_month" id="year_month" required>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label mb-3" for="user">Users</label>
                            <select class="form-control select2 mt-2" name="user[]" id="user" multiple="multiple" required>
                                <option value="0">All</option>
                                @foreach($users as $agent)
                                    <option value="{{$agent->user_id}}">{{$agent->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mt-4">
                        <button type="submit" class="btn btn-primary float-right px-5 mt-3">Generate</button>
                    </div>
                </div>
            </form>
                <div class="row">
                    <div class="col-12">
                        <div id="report_data" class="mt-5"></div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        let data_table=''
        $(document).ready(function (){
            $(".select2").select2();
        });
        $('#attendance_report_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('_token', "{{csrf_token()}}")
            let a = function () {
                data_table = $('#reports_table').DataTable({
                    paging: false,
                });
            };
            let arr = [a];
            call_ajax_with_functions('report_data', '{{route('generate_pay_role')}}', data, arr);
        });
        function save_payroll_form() {
            // reseting any search in datable
            $('#reports_table_filter input').val('');
            data_table.search('').columns().search('').draw();

            let data = new FormData($('#payroll_form_id')[0]);
            data.append('_token', '{{csrf_token()}}');
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            swal({
                title: "Are you sure?",
                text: "Once save payroll, you will not be able to re-create this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        call_ajax_with_functions('', '{{route('payroll_save')}}', data, arr);
                    }
                });
        }
    </script>
@endsection
