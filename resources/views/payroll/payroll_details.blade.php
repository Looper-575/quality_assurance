@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Payroll</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="table-responsive">
                <table class="table table-striped" id="payroll_table">
                    <thead>
                    <tr>
                        <th title="Field #1">Employee Name</th>
                        <th title="Field #2">Attendance Month</th>
                        <th title="Field #2">Attendance Marked</th>
                        <th title="Field #3">On Leave</th>
                        <th title="Field #6">Absents</th>
                        <th title="Field #7">Present</th>
                        <th title="Field #7">Basic Salary</th>
                        <th title="Field #9">Gross Salary</th>
                        <th title="Field #10">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payroll as $pay)
                        <tr>
                            <td>{{ $pay->user->full_name }}</td>
                            <td>{{ date('M-Y', strtotime($pay->salary_month)) }}</td>
                            <td>{{ $pay->attendance_marked }}</td>
                            <td>{{ $pay->leaves }}</td>
                            <td>{{ $pay->absents }}</td>
                            <td>{{ $pay->presents}}</td>
                            <td>{{$pay->basic_salary}}</td>
                            <td>{{$pay->gross_salary}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button title="Reject" class="btn btn-danger p-3" onclick="reject_payroll(this);" value="{{$pay->payroll_id}}"><i class="fa fa-times"></i></button>
                                    <button title="Approve" class="btn btn-success p-3" onclick="approve_payroll(this);" value="{{$pay->payroll_id}}"><i class="fa fa-check"></i></button>
                                    <a title="Edit" class="btn-primary p-3 text-white" style="border-radius: 0px 3px 3px 0px;" href="{{ route('payroll_edit', $pay->payroll_id) }}"><i class="fa fa-pencil"></i></a>
                                </div>
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
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#payroll_table').DataTable( {
            });
        });
        function reject_payroll (me) {
            let id = me.value;
            let data = new FormData();
            data.append('id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to reject this Payroll",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes, Reject Payroll!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    let a = function () {
                        window.location.href = "{{route('payroll_details')}}";
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('payroll_reject')}}', data, arr);
                }
            });
        }

        function approve_payroll (me) {
            let id = me.value;
            let data = new FormData();
            data.append('id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to approve this Payroll",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes, Approve Payroll!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    let a = function () {
                        window.location.href = "{{route('payroll_details')}}";
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('payroll_approve')}}', data, arr);
                }
            });
        }
    </script>
@endsection
