@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Leave Report</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="table-responsive">
                <table class="table dataTable table-striped" id="reports_table">
                    <thead>
                    <tr>
                        <th title="Field #1">Emoloyee</th>
                        <th title="Field #2">Remaining Annual Leaves</th>
                        <th title="Field #3">Remaining Casual</th>
                        <th title="Field #4">Remaining Sick</th>
                        <th title="Field #7">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($reports as $report)
                        <?php
                        $check_leave_bucket = get_leave_bucket_leaves($report->user_id);
                        ?>
                        <tr>
                            <td>{{ $report->user->full_name }}</td>
                            <td>{{$check_leave_bucket['remaining_annual']}}</td>
                            <td>{{$check_leave_bucket['remaining_casual']}}</td>
                            <td>{{$check_leave_bucket['remaining_sick']}}</td>
                            <td>
                                <button type="button" class="btn btn-primary view_btn" title="View Rerport" value="{{$report->user_id}}"><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#reports_table').DataTable( {
            });
        });
        $('.view_btn').click( function () {
            let id = this.value;
            let data = new FormData();
            data.append('user_id', id);
            data.append('_token', "{{csrf_token()}}");
            call_ajax_modal('post', '{{route('view_leave_report')}}', data, 'Leave Report');
        });
        $('#attendance_report_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('_token', "{{csrf_token()}}")
            let a = function () {
                $('#reports_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf',
                        {
                            extend: 'print',
                            customize: function (win) {
                                $(win.document.body).find('thead').prepend($('#report_header').html());
                            }
                        },
                    ]
                });
            };
            let arr = [a];
            call_ajax_with_functions('report_data', '{{route('generate_single_attendance_report')}}', data, arr);
        });
    </script>
@endsection



