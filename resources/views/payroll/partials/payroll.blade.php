<form id="payroll_form_id" action="javascript:save_payroll_form()" method="post">
<div class="table-responsive">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr id="report_header">
            <th colspan="4"><h5>Pay Role: <?php $yrdata = strtotime($month); echo date('M-Y', $yrdata); ?></h5></th>
            <th colspan="5"><h5>Total Working Days: {{$working_days}}</h5></th>
            <th colspan="3"><h5>Total Holidays: {{$holiday_count}}</h5></th>
        </tr>
        <tr>
            <th>Employee Name</th>
            <th>Attendance Marked</th>
            <th>On Leave</th>
            <th>Half Day Leave</th>
            <th>Lates</th>
            <th>Absents</th>
            <th>Present</th>
            <th>Basic Salary</th>
            <th>Deduction</th>
            <th>Allowance</th>
            <th>Gross Salary</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($attendance_list as $attendace_log)
            <tr>
                <td>{{ $attendace_log->user->full_name }}
                    <input type="hidden" name="user_id[]" value="{{$attendace_log->user->user_id}}">
                    <input type="hidden" name="salary_month[]" value="{{date('Y-m-d', $yrdata)}}">
                </td>
                <td>{{ $attendace_log->attendance_marked }}
                    <input type="hidden" name="attendance_marked[]" value="{{$attendace_log->attendance_marked}}">
                    <input type="hidden" name="attendance_not_marked[]" value="{{$working_days - $attendace_log->attendance_marked}}">
                </td>
                <td>{{ $attendace_log->leaves }} <input type="hidden" name="leaves[]" value="{{$attendace_log->leaves}}"></td>
                <td>{{ $attendace_log->half_leaves }} <input type="hidden" name="half_leaves[]" value="{{$attendace_log->half_leaves}}"></td>
                <td>{{ $attendace_log->lates }} <input type="hidden" name="lates[]" value="{{$attendace_log->lates}}"></td>
                <td>{{ $attendace_log->absents }} <input type="hidden" name="absents[]" value="{{$attendace_log->absents}}"></td>
                <td>{{ $attendace_log->attendance_marked - ($attendace_log->absents + $attendace_log->leaves) - $holiday_count}} <input type="hidden" name="presents[]" value="{{$attendace_log->attendance_marked - ($attendace_log->absents + $attendace_log->leaves) - $holiday_count}}"></td>
                <td> {{$attendace_log->user->employee->net_salary}} <input type="hidden" name="basic_salary[]" value="{{$attendace_log->user->employee->net_salary}}"></td>
                <td class="p-line-height pt-3">
                <?php $ded_det = $attendace_log->deductions;?>
                    <input type="hidden" name="leaves_of_late[]" value="{{$ded_det['leaves_of_late']}}">
                    <input type="hidden" name="leaves_of_half[]" value="{{$ded_det['leaves_of_half']}}">
                    <input type="hidden" name="deduction_bucket[]" value="{{$ded_det['deduction_bucket']}}">
                    @foreach($ded_det['details'] as $key => $ded)
                        <p>{{$ded}}:  <span class="float-right">{{number_format($key,0)}}</span></p>
                        <input value="{{$ded}}" name="deduction_title[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                        <input value="{{$key}}" name="deduction_value[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                    @endforeach
                    <p><b>Total:  <span class="float-right">{{ number_format($ded_det['total_deductions'], 0) }}</span></b></p>
                </td>
                <td class="p-line-height pt-3">
                    <?php $allowance = $attendace_log->allowance;?>
                        @foreach($attendace_log->allowance['details'] as $key => $allowanc)
                            <p>{{$key}}: <span class="float-right">{{$allowanc}}</span></p>
                            <input value="{{$key}}" name="allowance_title[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                            <input value="{{$allowanc}}" name="allowance_value[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                        @endforeach
                    <p><b>Total: <span class="float-right">{{$allowance['total_allowance']}}</span></b></p>
                </td>
                <td>
                     {{ number_format($attendace_log->user->employee->net_salary - $ded_det['total_deductions'] + $allowance['total_allowance'], 0)}}
                    <input type="hidden" name="gross_salary[]" value="{{$attendace_log->user->employee->net_salary - $ded_det['total_deductions'] + $allowance['total_allowance']}}">
                </td>
            </tr>
        @endforeach
        @foreach($payroll_exists as $user)
            <tr>
                <td>{{$user->full_name}}</td>
                <td colspan="10">Payroll Already Created!</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<button type="submit" id="payroll_form_btn"  class="btn btn-success float-right my-3"> Save Payroll</button>
</form>
<style>
    .p-line-height p{
        line-height: 0px;
    }
</style>
