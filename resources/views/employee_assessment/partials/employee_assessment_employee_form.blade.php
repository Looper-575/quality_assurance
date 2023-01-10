<div class="row">
    <div class="col-4">
        <div class="form-group">
            <span class="font-bold font-14">Employee Name:</span>
            <span class="font-14" id="name"></span>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <span class="font-bold font-14">Department:</span>
            <span class="font-14" id="department"></span>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <span class="font-bold font-14">Designation:</span>
            <span class="font-14" id="designation"></span>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="font-bold font-14" for="esa_duties">*  Please state your understanding of main duties, responsibilities.</label>
            <textarea type="text" rows="3" class="form-control" name="esa_duties" required> {{$EmployeeAssessment ? $EmployeeAssessment->esa_duties : ''}}</textarea>
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="esa_achievements">*  Please state your  most important achievement during this review time period.</label>
            <textarea type="text" rows="3" class="form-control" name="esa_achievements" required>{{$EmployeeAssessment ? $EmployeeAssessment->esa_achievements : ''}}</textarea>
        </div>
        <div class="form-group">
            <label class="font-bold font-14" for="esa_future_aims">*  Please state your aims and tasks for future.</label>
            <textarea type="text" rows="3" class="form-control" name="esa_future_aims" required>{{$EmployeeAssessment ? $EmployeeAssessment->esa_future_aims : ''}}</textarea>
        </div>
    </div>
</div>
<hr>
