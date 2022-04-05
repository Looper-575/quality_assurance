<form action="javascript:save_employee_family()" method="post" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-" id="family_info_form">
    <!--begin: Form Wizard Step 1 Body -->
    @csrf
     <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Family Details
                    </h3>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label for="dependents">* No of Dependents</label>
                            <input name="dependents" value="{{($employee_family && count($employee_family)>0 && $employee_kin) ? $employee_kin->dependents : ''}}" required min="0" type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" style="text-align: center;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="relationship">Relationship</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="name">Name</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="age">Age</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="education">Education</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="occupation">Occupation</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="actions">Actions</label>
                                            <button type="button" onclick="add_family_row(this);"
                                                    class="btn btn-sm btn-primary">+
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($employee_family && count($employee_family)>0)
                                    @foreach($employee_family as $family)
                                        <tr>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <select name="family_relationship[]" required class="form-control">
                                                        <option {{$family->relationship == 'father' ? 'selected' : ''}} value="father">Father</option>
                                                        <option {{$family->relationship == 'mother' ? 'selected' : ''}} value="mother">Mother</option>
                                                        <option {{$family->relationship == 'sibling' ? 'selected' : ''}} value="sibling">Sibling</option>
                                                        <option {{$family->relationship == 'spouse' ? 'selected' : ''}} value="spouse">Spouse</option>
                                                        <option {{$family->relationship == 'child' ? 'selected' : ''}} value="child">Child</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="family_name[]" value="{{$family ? $family->name : ''}}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="family_age[]" value="{{$family ? $family->age : ''}}" required type="number" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="family_education[]" value="{{$family ? $family->education : ''}}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="family_occupation[]" value="{{$family ? $family->occupation : ''}}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                @if($loop->index > 0)
                                                    <div class="form-group m-form__group">
                                                        <button type="button" onclick="remove_row(this);"
                                                                class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <select name="family_relationship[]" required class="form-control">
                                                    <option value="father">Father</option>
                                                    <option value="mother">Mother</option>
                                                    <option value="sibling">Sibling</option>
                                                    <option value="spouse">Spouse</option>
                                                    <option value="child">Child</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_name[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_age[]" value="" required type="number" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_education[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_occupation[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
{{--                                                <button type="button" onclick="remove_row(this);"--}}
{{--                                                        class="btn btn-sm btn_remove_edu btn-close btn-danger">X--}}
{{--                                                </button>--}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="m-separator m-separator--dashed m-separator--lg"></div>
            <div class="m-form__section">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Next of KIN
                    </h3>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group m-form__group">
                            <label for="kin_name">* Name</label>
                            <input name="kin_name" value="{{$employee_kin ? $employee_kin->kin_name : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group m-form__group">
                            <label for="kin_relation">* Relationship</label>
                            <input name="kin_relation" value="{{$employee_kin ? $employee_kin->kin_relation : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group m-form__group">
                            <label for="kin_cnic">* CNIC</label>
                            <input name="kin_cnic" value="{{$employee_kin ? $employee_kin->kin_cnic : ''}}" required type="text" pattern="[0-9]{5}[0-9]{7}[0-9]{1}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group m-form__group">
                            <label for="kin_contact_number">* Contact Number</label>
                            <input name="kin_contact_number" value="{{$employee_kin ? $employee_kin->kin_contact_number : ''}}" id="kin_contact_number" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group m-form__group">
                            <label for="kin_address">* Address</label>
                            <input name="kin_address" value="{{$employee_kin ? $employee_kin->kin_address : ''}}" id="kin_address" required type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group m-form__group">
                            <label for="any_illness_record">* Do you or any of your family member suffer or have suffered from any serious contagious illness or disability?</label>
                            <div class="m-radio-inline">
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="any_illness_record" value="YES" {{($employee_kin and $employee_kin->any_illness_record == 'YES')? 'checked' : ''}} class="form-control">
                                    YES
                                    <span></span>
                                </label>
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="any_illness_record" value="NO" {{($employee_kin and $employee_kin->any_illness_record == 'NO')? 'checked' : ''}} class="form-control">
                                    NO
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group m-form__group">
                            <label for="illness_details">* If YES, please give particulars</label>
                            <input name="illness_details" value="{{$employee_kin ? $employee_kin->illness_details : ''}}" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-separator m-separator--dashed m-separator--lg"></div>
            <div class="m-form__section">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        CERTIFICATE OF CORRECTNESS
                    </h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group m-form__group">
                            <label for="correctness_certificate">
                                Please make sure before submitting this form that you have answered all questions completely
                                and correctly. If any of the information furnished above is found to be incorrect, he/she will be liable for
                                dismissal without notice.
                            </label>
                        </div>
                        <div class="m-checkbox-inline">
                            <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                <input type="checkbox" name="correctness_certificate" value="1" required>
                                By clicking on this, I do solemnly affirm that the information furnished in this Employment Form is correct
                                to the best of my knowledge and belief and that I have withheld nothing which would affect my employment in this company.
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--begin: Form Actions -->
    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
        <div class="m-form__actions">
            @if($section_id && $section_id == 'family_info_form')
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2 m--align-left"></div>
                    <div class="col-lg-6 m--align-right">
                        <button type="submit"  class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                            <span>Save</span>
                        </button>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2 m--align-left">
                        <a id="4" href="#" class="btn_back btn btn-info m-btn m-btn--custom m-btn--icon" >
                           <span><i class="la la-arrow-left"></i><span>Back</span></span>
                        </a>
                    </div>
                    <div class="col-lg-6 m--align-right">
                        <button type="submit"  class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                           <span><span>Save & Continue</span><i class="la la-arrow-right"></i></span>
                        </button>
                        <a id="4" href="#" class="btn_skip btn btn-info m-btn m-btn--custom m-btn--icon" >
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
