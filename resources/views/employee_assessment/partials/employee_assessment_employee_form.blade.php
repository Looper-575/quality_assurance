<div class="row">
<div class="col-lg-4">
    <div class="form-group m-form__group">
        <label for="name"><b>Employee Name:</b> </label>
        <label for="name" id="name"></label>
    </div>
</div>
<div class="col-lg-4">
    <div class="form-group m-form__group">
        <label for="department"><b>Department:</b> </label>
        <label for="department" id="department"></label>
    </div>
</div>
<div class="col-lg-4">
    <div class="form-group m-form__group">
        <label for="designation"><b>Designation:</b> </label>
        <label for="designation" id="designation"></label>
    </div>
</div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group m-form__group">
            <label for="esa_duties"><b>*  Please state your understanding of main duties, responsibilities.</b></label>
            <textarea type="text" rows="6" style="width: 100%; max-width: 100%;" name="esa_duties" required>{{$EmployeeAssessment ? $EmployeeAssessment->esa_duties : ''}}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group m-form__group">
            <label for="esa_achievements"><b>*  Please state your  most important achievement during this review time period.</b></label>
            <textarea type="text" rows="6" style="width: 100%; max-width: 100%;" name="esa_achievements" required>{{$EmployeeAssessment ? $EmployeeAssessment->esa_achievements : ''}}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group m-form__group">
            <label for="esa_future_aims"><b>*  Please state your aims and tasks for future.</b></label>
            <textarea type="text" rows="6" style="width: 100%; max-width: 100%;" name="esa_future_aims" required>{{$EmployeeAssessment ? $EmployeeAssessment->esa_future_aims : ''}}</textarea>
        </div>
    </div>
</div>
