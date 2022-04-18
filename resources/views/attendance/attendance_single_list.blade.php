@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Single User Attendance Report</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="attendance_report_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label" for="form_date">Form Date</label>
                            <input class="form-control" type="date" name="form_date" id="form_date" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label" for="to_date">To Date</label>
                            <input class="form-control" type="date" name="to_date" id="to_date" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label" for="user_id">Users</label>
                            <select class="form-control" name="user_id" id=user_id" required>
                                <option value="">Select User</option>
                                @foreach($agents as $agent)
                                    <option value="{{$agent->user_id}}">{{$agent->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pb-5">
                        <button type="submit"  class="btn btn-primary float-right"> Generate</button>
                    </div>
                    <br>
                    <div class="col-12">
                        <div id="report_data"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $('#attendance_report_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('_token', "{{csrf_token()}}")
            let a = function () {
                $('#reports_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            };
            let arr = [a];
            call_ajax_with_functions('report_data', '{{route('generate_signle_attendance_report')}}', data, arr);
        });
    </script>
@endsection


