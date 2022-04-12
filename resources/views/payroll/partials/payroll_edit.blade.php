@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Edit Payroll</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
{{--            action="javascript:save_payroll_form()"--}}
            <form id="edit_payroll_form_id" method="post">
                @csrf
                {{--    @dd($payroll);--}}
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="name">Employee Name</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$payroll->user->full_name}}" disabled>
                            <input type="hidden" name="user_id" id="user_id" value="{{$payroll->user->user_id}}">
                            <input type="hidden" name="payroll_id" id="payroll_id" value="{{$payroll->payroll_id}}">
                            <input type="hidden" name="basic_salary" id="basic_salary" value="{{$payroll->basic_salary}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="salary_month">Salary Month</label>
                            <input class="form-control" type="text" name="salary_month" id="salary_month" value="<?php $yrdata = strtotime($payroll->salary_month); echo date('M-Y', $yrdata); ?>" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="basic_salary">Basic Salary</label>
                            <input class="form-control" type="text" name="basic_salary" id="basic_salary" value="{{$payroll->basic_salary}}" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="gross_salary">Net Salary</label>
                            <input class="form-control" type="text" name="gross_salary" id="gross_salary" value="{{$payroll->gross_salary}}" disabled>
                        </div>
                    </div>
{{--                    <div class="col-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="attendance_marked">Attendance Marked</label>--}}
{{--                            <input class="form-control" type="text" name="attendance_marked" id="attendance_marked" value="{{$payroll->attendance_marked}}" disabled>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="attendance_not_marked">Attendance Not Marked</label>--}}
{{--                            <input class="form-control" type="text" name="attendance_not_marked" id="attendance_not_marked" value="{{$payroll->attendance_not_marked}}" disabled>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="leaves">Leaves</label>--}}
{{--                            <input class="form-control" type="text" name="leaves" id="leaves" value="{{$payroll->leaves}}" disabled>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="half_leaves">Half Leaves</label>--}}
{{--                            <input class="form-control" type="text" name="half_leaves" id="half_leaves" value="{{$payroll->half_leaves}}" disabled>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="lates">Lates</label>--}}
{{--                            <input class="form-control" type="text" name="lates" id="lates" value="{{$payroll->lates}}" disabled>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="absents">Absents</label>--}}
{{--                            <input class="form-control" type="text" name="absents" id="absents" value="{{$payroll->absents}}" disabled>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-4">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="presents">Presents</label>--}}
{{--                            <input class="form-control" type="text" name="presents" id="presents" value="{{$payroll->presents}}" disabled>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-6">
                        <div class="form-group">
                            <h6 class="form-check-label" for="deductions">Deductions</h6>
                            @foreach($payroll->payroll_deduction as $deduction)
                                <div class="form-group">
                                    <label class="form-check-label" for="deduction">{{$deduction->title}}</label>
                                    <input class="form-control deductions" type="text" name="deduction[{{$deduction->id}}]" id="deduction" value="{{$deduction->amount}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <h6 class="form-check-label" for="allowance">Allowance</h6>
                            @foreach($payroll->payroll_allowance as $allowance)
                                <div class="form-group">
                                    <label class="form-check-label" for="allowance">{{$allowance->title}}</label>
                                    <input class="form-control allowances" type="text" name="allowance[{{$allowance->id}}]" id="allowance" value="{{$allowance->amount}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 d-none">
                        <table class="table table-bordered" id="mark_tid" style="width:100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th title="Field #10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($attendance as $agent_list)
                                <tr>
                                    <td>
                                    <input type="hidden" name="attendance_id" value="{{$agent_list->attendance_id}}" id="row_{{$agent_list->attendance_id}}">
                                    {{ $agent_list->attendance_date }}
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" onchange="time_in_set({{@$agent_list->attendance_id}})" name="time_in" value="{{$agent_list->time_in}}" id="time_in_{{@$agent_list->attendance_id}}">
                                    </td>
                                    <td>
                                        <input class="form-control" type="time" name="time_out" onchange="time_out_set({{@$agent_list->attendance_id}})" value="{{$agent_list->time_out}}" id="time_out_{{@$agent_list->attendance_id}}" >
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="half_leave_{{@$agent_list->attendance_id}}"
                                                onclick="mark_on_leave({{@$agent_list->attendance_id}})"
                                                id="on_leave_{{@$agent_list->attendance_id}}"
                                                {{  ($agent_list->on_leave == 1 ? ' checked' : '') }}
                                            /><label class="form-check-label pr-4 mt-1" for="on_leave_{{@$agent_list->attendance_id}}"> On Leave</label>

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="half_leave_{{@$agent_list->attendance_id}}"
                                                onclick="mark_half_leave({{@$agent_list->attendance_id}})"
                                                id="half_leave_{{@$agent_list->attendance_id}}"
                                                {{  ($agent_list->half_leave == 1 ? ' checked' : '') }}
                                            /><label class="form-check-label pr-4 mt-1" for="half_leave_{{@$agent_list->attendance_id}}"> Half Leave</label>

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="agent_attendance_{{@$agent_list->attendance_id}}"
                                                onclick="mark_late({{@$agent_list->attendance_id}})"
                                                id="late_{{@$agent_list->attendance_id}}"
                                                {{  ($agent_list->late == 1 ? ' checked' : '') }}
                                                {{  ($agent_list->absent == 1 ? ' disabled' : '') }}
                                            /><label class="form-check-label pr-4 mt-1" for="late_{{@$agent_list->attendance_id}}"> Late</label>

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                onclick="mark_absent({{@$agent_list->attendance_id}})"
                                                name="agent_attendance_{{@$agent_list->attendance_id}}"
                                                id="absent_{{@$agent_list->attendance_id}}"
                                                {{  ($agent_list->absent == 1 ? ' checked' : '') }}
                                                {{  ($agent_list->late == 1 ? ' disabled' : '') }}
                                            /><label class="form-check-label pr-4 mt-1" for="absent_{{@$agent_list->attendance_id}}">Absent</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-success float-right" onclick="save_payroll_form(this)" value="save">Save</button>
                        <button type="button" class="btn btn-primary float-right mx-2" onclick="save_payroll_form(this)" value="approve">Approve</button>
                        <button type="button" class="btn btn-danger float-right" onclick="save_payroll_form(this)" value=reject>Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(".deductions, .allowances").keyup(function(){
            change_values();
        });
        function change_values() {
            let deduction_val  = 0;
            let allowance_val = 0;
            $('.deductions').each(function(){
                let deduction = $(this).val();
                deduction_val += parseFloat(deduction);
            });
            $('.allowances').each(function (){
                let allowace = $(this).val();
                allowance_val += parseFloat(allowace);
            });
            let basic_salary =  $('#basic_salary').val();
            let gross_salary_val = (basic_salary - deduction_val) + allowance_val;
            $('#gross_salary').val(gross_salary_val);
        }
        function save_payroll_form(me) {
            let type = me.value;
            let data = new FormData($('#edit_payroll_form_id')[0]);
            data.append('_token', '{{csrf_token()}}');
            data.append('type', type);

            let a = null;
            if(type == 'save' ){
                a = function() {
                    window.location.reload();
                }
            } else {
                a = function() {
                    window.location.href = "{{route('payroll_details')}}";
                }
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('payroll_save_edit')}}', data, arr);
        }
        function time_in_set(e) {
            var user_id = e;
            var time_in = $("#time_in_"+user_id).val();
            var row_id = $("#row_"+user_id).val();
            $.ajax({
                type:'POST',
                url:'{{ route('mark_attendance') }}',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: user_id,
                    time_in: time_in,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function time_out_set(e) {
            var user_id = e;
            var time_in = $("#time_in_"+user_id).val();
            var time_out = $("#time_out_"+user_id).val();
            var row_id = $("#row_"+user_id).val();
            $.ajax({
                type:'POST',
                url:'{{ route('mark_attendance') }}',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: user_id,
                    time_out: time_out,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                    toastr.success('Updated Successfully!');
                }
            });
        }
        function mark_on_leave(e) {
            var id = e;
            var row_id = $("#row_"+id).val();
            var on_leave = '';
            if($("#on_leave_"+id).is(':checked') == true){
                on_leave = 1;
                $("#time_out_"+id).val('');
            }
            else{
                on_leave = 0;
            }
            $.ajax({
                type:'POST',
                url:'{{ route('mark_attendance') }}',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    on_leave: on_leave,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function mark_half_leave(e) {
            var id = e;
            var row_id = $("#row_"+id).val();
            var half_leave = '';
            if($("#half_leave_"+id).is(':checked') == true){
                half_leave = 1;
            }
            else{
                half_leave = 0;
            }
            $.ajax({
                type:'POST',
                url:'{{ route('mark_attendance') }}',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    half_leave: half_leave,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function mark_late(e) {
            var id = e;
            var row_id = $("#row_"+id).val();
            var late = '';
            if($("#late_"+id).is(':checked') == true){
                late = 1;
                $("#absent_"+id).prop("checked", false);
                $("#absent_"+id).prop("disabled", true);
            }
            else{
                late = 0;
                $("#absent_"+id).prop("disabled", false);
            }
            $.ajax({
                type:'POST',
                url:'{{ route('mark_attendance') }}',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    late: late,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function mark_absent(e) {
            var id = e;
            var row_id = $("#row_"+id).val();
            var absent = '';
            if($("#absent_"+id).is(':checked') == true){
                $("#time_in_"+id).val('');
                $("#time_out_"+id).val('');
                absent = 1;
                $("#late_"+id).prop("checked", false);
                $("#late_"+id).prop("disabled", true);
            }
            else{
                absent = 0;
                $("#late_"+id).prop("disabled", false);
            }
            $.ajax({
                type:'POST',
                url:'{{ route('mark_attendance') }}',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    absent: absent,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                    toastr.success('Updated Successfully!')
                }
            });
        }
    </script>
@endsection

