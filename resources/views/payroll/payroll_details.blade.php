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
            <div class="float-right mr-4" style="height: 50px">
                <span id="selected_btn">
                    <button class="btn btn-danger" title="Reject Selected Payroll" onclick="reject_selected_payroll()">Reject</button>
                    <button class="btn btn-success" title="Approve Selected Payroll" onclick="approve_selected_payroll()">Approve</button>
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="payroll_table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="checkAll" id="checkAll"></th>
                        <th>Employee Name</th>
                        <th>Attendance Month</th>
                        <th>Attendance Marked</th>
                        <th>Holidays</th>
                        <th>On Leave</th>
                        <th>Absents</th>
                        <th>Present</th>
                        <th>Basic Salary</th>
                        <th>Gross Salary</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payroll as $pay)
                        <tr>
                            <td> <input type="checkbox" name="payroll_id[]" class="payroll_ids" value="{{$pay->payroll_id}}"></td>
                            <td>{{ $pay->user->full_name }}</td>
                            <td>{{ date('M-Y', strtotime($pay->salary_month)) }}</td>
                            <td>{{ $pay->attendance_marked }}</td>
                            <td>{{ $pay->holiday_count }}</td>
                            <td>{{ $pay->leaves }}</td>
                            <td>{{ $pay->absents }}</td>
                            <td>{{ $pay->presents}}</td>
                            <td>{{$pay->basic_salary}}</td>
                            <td>{{$pay->gross_salary}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button title="Delete" class="btn btn-danger p-3" onclick="reject_payroll(this);" value="{{$pay->payroll_id}}"><i class="fa fa-trash"></i></button>
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
        let selected_payroll_ids = [];
        function approve_selected_payroll(){
            selected_payroll_ids = [];
            $(".payroll_ids:checked").each(function(){
                selected_payroll_ids.push($(this).val());
            });
            let data = new FormData();
            data.append('_token', '{{csrf_token()}}');
            data.append('id', selected_payroll_ids);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('payroll_approve')}}', data, arr);
        }
        function reject_selected_payroll(){
            selected_payroll_ids = [];
            $(".payroll_ids:checked").each(function(){
                selected_payroll_ids.push($(this).val());
            });
            let data = new FormData();
            data.append('_token', '{{csrf_token()}}');
            data.append('id', selected_payroll_ids);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('payroll_reject')}}', data, arr);
        }
        $("#checkAll").change(function(){
            if ($('#checkAll').prop('checked')) {
                $('.payroll_ids').prop('checked',true);
                $('#selected_btn').css('display','block');
            } else {
                $('.payroll_ids').prop('checked', false);
                $('#selected_btn').css('display','none');
            }
        });
        $('.payroll_ids').change(function (){
            selected_payroll_ids = [];
            $(".payroll_ids:checked").each(function(){
                selected_payroll_ids.push($(this).val());
            });
            if(selected_payroll_ids.length>0){
                $('#selected_btn').css('display','block');
            } else {
                $('#selected_btn').css('display','none');
                $('#checkAll').prop('checked',false);
            }
        });
        $(document).ready(function() {
            $('#selected_btn').css('display','none');
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
