<div class="row">
    <div class="col-6">
        <div class="form-group">
            <span class="font-bold font-14">Employee Name:</span>
            <span class="font-14">{{$EmployeeAssessment ? $EmployeeAssessment->employees->full_name : ''}}</span>
        </div>
        <div class="form-group">
            <span class="font-bold font-14">Department:</span>
            <span class="font-14">{{$EmployeeAssessment ? $EmployeeAssessment->employees->department->title : ''}}</span>
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="period"><b>Period:</b> </label>
            <input name="period" id="period" value="{{$period ? $period : ''}}" readonly required type="text" class="form-control">
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="attendance"><b>* Attendance (%):</b> </label>
            <input name="attendance" step="any" value="{{($EmployeeAssessment && isset($EmployeeAssessment->attendance))  ? $EmployeeAssessment->attendance : $attendance_log['presents']}}" required type="number" min="0" class="form-control">
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="written_warning"><b>* Written Warnings:</b> </label>
            <input name="written_warning" value="{{$EmployeeAssessment ? $EmployeeAssessment->written_warning : '0'}}" required type="number" min="0" class="form-control">
        </div>
        <div class="form-group">
            <span class="font-bold font-14">Employee Current Status:</span>
            <span class="font-14">{{$EmployeeAssessment->employees->employment_status}}</span>
            <input type="hidden" name="employee_current_status" value="{{$EmployeeAssessment->employees->employment_status}}">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <span class="font-bold font-14">Designation:</span>
            <span class="font-14">{{$EmployeeAssessment ? $EmployeeAssessment->employees->designation : ''}}</span>
        </div>
        <div class="form-group">
            <span class="font-bold font-14">Date of Joining:</span>
            <span class="font-14">{{$EmployeeAssessment ? $EmployeeAssessment->employees->joining_date : ''}}</span>
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="total_service"><b>Total Service:</b> </label>
            <input name="total_service" id="total_service" value="{{$total_service ? $total_service : ''}}" readonly required type="text" class="form-control">
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="tardiness"><b>* Tardiness (%):</b> </label>
            <input name="tardiness" step="any" value="{{($EmployeeAssessment && isset($EmployeeAssessment->tardiness) ) ? $EmployeeAssessment->tardiness : $attendance_log['late']}}" required type="number" min="0" class="form-control">
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="verbal_warning"><b>* Verbal Warnings:</b> </label>
            <input name="verbal_warning" value="{{$EmployeeAssessment ? $EmployeeAssessment->verbal_warning : '0'}}" required type="number" min="0" class="form-control">
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="increment"><b>Increment (*if any)</b></label>
            <input name="increment" value="{{$EmployeeAssessment ? $EmployeeAssessment->increment : '0'}}" type="number" min="0" class="form-control">
        </div>
    </div>
</div>
@if($prob_status != 'Confirmed')
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label class="font-bold font-14" for="confirmation_status"><b>* Employee Status:</b> </label>
                <div class="m-radio-inline">
                    <label class="m-radio m-radio--solid m-radio--brand">
                        <input type="radio" required name="confirmation_status" value="Probation" {{($EmployeeAssessment and $EmployeeAssessment->confirmation_status == 'Probation')? 'checked' : ''}} class="form-control">
                        Probation
                        <span></span>
                    </label>
                    <label class="m-radio m-radio--solid m-radio--brand">
                        <input type="radio" required name="confirmation_status" value="Confirmed" {{($EmployeeAssessment and $EmployeeAssessment->confirmation_status == 'Confirmed')? 'checked' : ''}} class="form-control">
                        Confirmed
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="font-bold font-14" for="probation_extension"><b>* Probation Extension:</b> </label>
                <div class="m-radio-inline">
                    <label class="m-radio m-radio--solid m-radio--brand">
                        <input type="radio" required name="probation_extension" value="YES" {{($EmployeeAssessment and $EmployeeAssessment->probation_extension == 'YES')? 'checked' : ''}} class="form-control">
                        YES
                        <span></span>
                    </label>
                    <label class="m-radio m-radio--solid m-radio--brand">
                        <input type="radio" required name="probation_extension" value="NO" {{($EmployeeAssessment and $EmployeeAssessment->probation_extension == 'NO')? 'checked' : ''}} class="form-control">
                        NO
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-bold font-14" for="probation_extension_to_date"><b>* Probation Extension To Date:</b> </label>
                <input name="probation_extension_to_date" value="{{$EmployeeAssessment ? $EmployeeAssessment->probation_extension_to_date : ''}}" type="date" class="form-control">
            </div>
        </div>
    </div>
@else
    <input type="hidden" name="confirmation_status" value="Confirmed">
    <input type="hidden" name="probation_extension" value="NO">
    <input type="hidden" name="probation_extension_to_date" value="">
@endif
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="font-bold font-14" for="hr_comments"><b>* HR Additional Comments:</b> </label>
            <textarea type="text" name="hr_comments" rows="3" style="width: 100%; max-width: 100%;">{{$EmployeeAssessment ? $EmployeeAssessment->hr_comments : ''}}</textarea>
        </div>
    </div>
</div>