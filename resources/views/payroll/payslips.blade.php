@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Payslips</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="table-responsive">
                <table class="table table-striped" id="payroll_table">
                    <thead>
                    <tr>
                        <th title="Field #1">Employee Name</th>
                        <th title="Field #1">Salary Month</th>
                        <th title="Field #2">Attendance Marked</th>
                        <th title="Field #2">Holidays</th>
                        <th title="Field #3">On Leave</th>
                        <th title="Field #6">Absents</th>
                        <th title="Field #7">Present</th>
                        <th title="Field #7">Basic Salary</th>
                        <th title="Field #9">Gross Salary</th>
                        <th title="Field #10">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payslips as $pay)
                        <tr>
                            <td>{{ $pay->user->full_name }}</td>
                            <td>{{ date('M-Y', strtotime($pay->salary_month)) }}</td>
                            <td>{{ $pay->attendance_marked }}</td>
                            <td>{{ $pay->holiday_count }}</td>
                            <td>{{ $pay->leaves }}</td>
                            <td>{{ $pay->absents }}</td>
                            <td>{{ $pay->presents}}</td>
                            <td>{{$pay->basic_salary}}</td>
                            <td>{{intval($pay->gross_salary)}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button title="Reject" class="btn btn-primary" onclick="view_payroll(this);" value="{{$pay->payroll_id}}"><i class="fa fa-eye"></i></button>
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
        function print_payslip(){
            var divToPrint=document.getElementById("payslip_print");
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
        }
        $(document).ready(function() {
            $('#payroll_table').DataTable( {
            });
        });
        function view_payroll (me) {
            let id = me.value;
            let data = new FormData();
            data.append('id', id);
            data.append('_token', "{{csrf_token()}}");
            call_ajax_modal('post', '{{route('view_payslip')}}', data, 'Payslip');
        }
    </script>
@endsection
