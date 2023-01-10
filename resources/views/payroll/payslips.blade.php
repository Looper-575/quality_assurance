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
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                <form method="post" id="payslips_report_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label" for="year_month">Payslip Month</label>
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
                        <button type="submit" class="btn btn-primary float-right px-5 mt-3">Search</button>
                    </div>
                </div>
            </form>
            @endif
            <div class="table-responsive" id="payslips_report_data">
                <table class="table datatble table-striped" id="payroll_table">
                    <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Salary Month</th>
                        <th>EOBI Deduction</th>
                        <th>Income Tax Deduction</th>
                        <th>Other Deductions</th>
                        <th>Basic Salary</th>
                        <th>Gross Salary</th>
                        <th>Account Number</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payslips as $pay)
                        <tr>
                            <td>{{ $pay->user->full_name }}</td>
                            <td>{{ date('M-Y', strtotime($pay->salary_month)) }}</td>
                            <td>{{ $pay->eobi }}</td>
                            <td>{{ $pay->income_tax }}</td>
                            <td>{{ $pay->deduction_amount }}</td>
                            <td>{{$pay->basic_salary}}</td>
                            <td>{{intval($pay->gross_salary)}}</td>
                            <td>{{$pay->user->employee->account_number}}</td>
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
        $(document).ready(function() {
            $(".select2").select2();
            $('#payroll_table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf','print',
                ]
            });
        });
        $('#payslips_report_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('_token', "{{csrf_token()}}")
            let a = function () {
                $('#payroll_search_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf','print',
                    ]
                });
            };
            let arr = [a];
            call_ajax_with_functions('payslips_report_data', '{{route('search_payslips')}}', data, arr);
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
