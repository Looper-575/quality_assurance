<form action="javascript:save_employee_experience()" method="post" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-" id="experience_info_form">
    <!--begin: Form Wizard Step 1 Body -->
    @csrf
     <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Experience Details
                    </h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" style="text-align: center;">
                            <table class="table table-bordered" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="employer_name">* Employer Name</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="employer_contact_number">* Employer Contact Number</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="position_held">* Position Held</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="leave_reason">* Reason for Leaving</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="gross_salary">* Gross Salary</label>
                                        </div>
                                    </th>
                                    <th rowspan="2" style="text-align: center">
                                        <label for="date">* DATE</label>
                                        <div class="d-flex justify-content-between">
                                            <label for="from_date">From</label>
                                            <label style="border-right: 1px solid black; width: 5px;height: auto;"></label>
                                            <label for="to_date">To</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="actions">Actions</label>
                                            <button type="button" onclick="add_exp_row(this);"
                                                    class="btn btn-sm btn-primary">+
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($employee_experience && count($employee_experience)>0)
                                @foreach($employee_experience as $experience)
                                <tr>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_employer_name[]" value="{{$experience ? $experience->employer_name : ''}}" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_employer_contact_number[]" value="{{$experience ? $experience->employer_contact_number : ''}}" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_position_held[]" value="{{$experience ? $experience->position_held : ''}}" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_leave_reason[]" value="{{$experience ? $experience->leave_reason : ''}}" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_gross_salary[]" value="{{$experience ? $experience->gross_salary : ''}}" required type="number" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group d-flex">
                                            <input name="experience_from_date[]" value="{{$experience ? $experience->from_date : ''}}" required type="date" class="form-control" >
                                            <input name="experience_to_date[]" value="{{$experience ? $experience->to_date : ''}}" required type="date" class="form-control" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <button type="button" onclick="remove_row(this);"
                                                    class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_employer_name[]" value="" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_employer_contact_number[]" value="" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_position_held[]" value="" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_leave_reason[]" value="" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="experience_gross_salary[]" value="" required type="number" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group d-flex">
                                            <input name="experience_from_date[]" value="" required type="date" class="form-control" >
                                            <input name="experience_to_date[]" value="" required type="date" class="form-control" >
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <button type="button" onclick="remove_row(this);"
                                                    class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label for="approach_previous_employer">* May we approach your Previous Employer?</label>
                            <div class="m-radio-inline">
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="approach_previous_employer" value="YES" {{($employee and $employee->approach_previous_employer == 'YES')? 'checked' : ''}} class="form-control">
                                    YES
                                    <span></span>
                                </label>
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="approach_previous_employer" value="NO" {{($employee and $employee->approach_previous_employer == 'NO')? 'checked' : ''}} class="form-control">
                                    NO
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label for="previous_employer_service_bond">* Are you under any Service Bond with your Previous Employer?</label>
                            <div class="m-radio-inline">
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="previous_employer_service_bond" value="YES" {{($employee and $employee->previous_employer_service_bond == 'YES')? 'checked' : ''}} class="form-control">
                                    YES
                                    <span></span>
                                </label>
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="previous_employer_service_bond" value="NO" {{($employee and $employee->previous_employer_service_bond == 'NO')? 'checked' : ''}} class="form-control">
                                    NO
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label for="service_bond_reason">* If YES, state reason</label>
                            <input name="service_bond_reason" value="{{$employee ? $employee->service_bond_reason : ''}}" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--begin: Form Actions -->
    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
        <div class="m-form__actions">
            @if($section_id && $section_id == 'experience_info_form')
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2 m--align-left"></div>
                    <div class="col-lg-6 m--align-right">
                        <button type="submit" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                            <span>Save</span>
                        </button>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2 m--align-left">
                        <a id="3" href="#" class="btn_back btn btn-info m-btn m-btn--custom m-btn--icon" >
                           <span><i class="la la-arrow-left"></i><span>Back</span></span>
                        </a>
                    </div>
                    <div class="col-lg-6 m--align-right">
                        <button type="submit" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                           <span><span>Save & Continue</span><i class="la la-arrow-right"></i></span>
                        </button>
                        <a id="3" href="#" class="btn_skip btn btn-info m-btn m-btn--custom m-btn--icon" >
                            <span><i class="la la-arrow-right"></i><span>Skip</span></span>
                        </a>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            @endif
        </div>
    </div>
    <!--end: Form Actions -->
</form>
<script>

</script>
