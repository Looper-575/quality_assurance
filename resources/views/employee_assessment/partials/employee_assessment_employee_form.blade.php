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
            <label for="ESA_duties"><b>*  Please state your understanding of main duties, responsibilities.</b></label>
            <textarea type="text" rows="3" cols="120" name="ESA_duties" required>{{$EmployeeAssessment ? $EmployeeAssessment->ESA_duties : ''}}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group m-form__group">
            <label for="ESA_achievements"><b>*  Please state your  most important achievement during this review time period.</b></label>
            <textarea type="text" rows="3" cols="120" name="ESA_achievements" required>{{$EmployeeAssessment ? $EmployeeAssessment->ESA_achievements : ''}}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group m-form__group">
            <label for="ESA_future_aims"><b>*  Please state your aims and tasks for future.</b></label>
            <textarea type="text" rows="3" cols="120" name="ESA_future_aims" required>{{$EmployeeAssessment ? $EmployeeAssessment->ESA_future_aims : ''}}</textarea>
        </div>
    </div>
</div>
