<form id="payroll_form_id" action="javascript:save_payroll_form()" method="post">
    <table class="table table-bordered table-striped">
        <tbody>
        <tr id="report_header">
            <th><h5>Month: <?php $yrdata = strtotime($month); echo date('M-Y', $yrdata); ?></h5></th>
            <th><h5>Total Working Days: {{$working_days}}</h5></th>
        </tr>
        </tbody>
    </table>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="reports_table">
        <thead>
        <tr>
            <th>Employee Name</th>
            <th>Attendance Details</th>
            <th>Attendance Details 2</th>
            <th>Basic Salary</th>
            <th>Deduction Detail</th>
            <th>Allowance Detail</th>
            <th>Gross Salary</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($attendance_list as $attendace_log)
            <tr>
                <td>{{ $attendace_log->user->full_name }} ({{$attendace_log->user->employee->designation}})
                    <input type="hidden" name="user_id[]" value="{{$attendace_log->user->user_id}}">
                    <input type="hidden" name="salary_month[]" value="{{date('Y-m-d', $yrdata)}}">
                </td>
                <td>
                    Present: {{ $attendace_log->attendance_marked - ($attendace_log->absents + $attendace_log->leaves)}}
                    Holidays: {{$attendace_log->holiday_count}} <br>
                    Marked: {{$attendace_log->attendance_marked}}
                    Unmarked: {{$working_days - ($attendace_log->attendance_marked + $attendace_log->holiday_count)}}
                    <input type="hidden" name="presents[]" value="{{$attendace_log->attendance_marked - ($attendace_log->absents + $attendace_log->leaves)}}">
                    <input type="hidden" name="attendance_not_marked[]" value="{{$working_days - ($attendace_log->attendance_marked + $attendace_log->holiday_count)}}">
                    <input type="hidden" name="attendance_marked[]" value="{{$attendace_log->attendance_marked}}">
                </td>
                <td>
                    On Leave: {{ $attendace_log->leaves }}
                    Half Days: {{ $attendace_log->half_leaves }} <br>
                    Lates: {{ $attendace_log->lates }}
                    Absents: {{ $attendace_log->absents }}
                    <input type="hidden" name="leaves[]" value="{{$attendace_log->leaves}}">
                    <input type="hidden" name="half_leaves[]" value="{{$attendace_log->half_leaves}}">
                    <input type="hidden" name="lates[]" value="{{$attendace_log->lates}}">
                    <input type="hidden" name="absents[]" value="{{$attendace_log->absents}}">
                </td>
                <td> {{intval($attendace_log->user->employee->net_salary - $attendace_log->medical_allowance)}} <input type="hidden" name="basic_salary[]" value="{{$attendace_log->user->employee->net_salary - $attendace_log->medical_allowance}}"></td>
                <td class="p-line-height pt-3">
                <?php $ded_det = $attendace_log->deductions;?>
                    <div class="container-fluid">
                    <input type="hidden" name="carry_forward_half_day[]" value="{{$ded_det['carry_forward_half_day']}}">
                    <input type="hidden" name="leaves_of_half[]" value="{{$ded_det['leaves_of_half']}}">
                    <input type="hidden" name="deduction_bucket[]" value="{{$ded_det['deduction_bucket']}}">
                    <div class="row">
                        @foreach($ded_det['details'] as $key => $ded)
                            <div class="col-8"><p style="white-space: nowrap;">{{$ded}}: </p></div>
                            <div class="col-4"><p class="float-right">{{$key}}</p></div>
                            <input value="{{$ded}}" name="deduction_title[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                            <input value="{{$key}}" name="deduction_value[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                        @endforeach
                        <div class="col-8"><p style="white-space: nowrap;"><b>Total Deductions:</b></p></div>
                        <div class="col-4"><p class="float-right"><b>{{ intval($ded_det['total_deductions']) }}</b></p></div>
                    </div>
                    </div>
                </td>
                <td class="p-line-height pt-3">
                    <?php $allowance = $attendace_log->allowance;?>
                    <div class="container-fluid">
                    <div class="row">
                        @foreach($attendace_log->allowance['details'] as $key => $allowanc)
                            <div class="col-8"><p style="white-space: nowrap;">{{$key}}: </p></div>
                            <div class="col-4"><p class="float-right">{{intval($allowanc)}}</p></div>
                            <input value="{{$key}}" name="allowance_title[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                            <input value="{{$allowanc}}" name="allowance_value[{{$attendace_log->user->user_id}}][]" type="hidden" class="form-control" />
                        @endforeach
                        <div class="col-8"><p><b>Total Allowance:</b></p></div>
                        <div class="col-4"><p class="float-right"><b>{{intval($allowance['total_allowance'])}}</b></p></div>
                    </div>
                    </div>
                </td>
                <td>
                     {{ intval(($attendace_log->user->employee->net_salary - $attendace_log->medical_allowance) - $ded_det['total_deductions'] + $allowance['total_allowance'])}}
                    <input type="hidden" name="gross_salary[]" value="{{ intval(($attendace_log->user->employee->net_salary - $attendace_log->medical_allowance) - $ded_det['total_deductions'] + $allowance['total_allowance'])}}">
                </td>
            </tr>
        @endforeach
        @foreach($payroll_exists as $user)
            <tr>
                <td>{{$user->full_name}} ({{$user->employee->designation}})</td>
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
