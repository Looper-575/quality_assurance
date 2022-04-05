<form action="javascript:save_employee_emergency_contact()" method="post" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-" id="emergency_contact_info_form">
    <!--begin: Form Wizard Step 1 Body -->
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Emergency Contact Details
                    </h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="emergency_contact_name">* Name</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="emergency_contact_relation">* Relationship</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="emergency_contact_cnic">* CNIC</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="emergency_contact_number">* Contact Number</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="emergency_contact_address">* Address</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="actions">Actions</label>
                                            <button type="button" onclick="add_emergency_contact_row(this);"
                                                    class="btn btn-sm btn-primary">+
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($employee_emergency_contact && count($employee_emergency_contact)>0)
                                    @foreach($employee_emergency_contact as $emergency_contact)
                                        <tr>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="emergency_contact_name[]" value="{{$emergency_contact ? $emergency_contact->emergency_contact_name : ''}}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="emergency_contact_relation[]" value="{{$emergency_contact ? $emergency_contact->emergency_contact_relation : ''}}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="emergency_contact_cnic[]" value="{{$emergency_contact ? $emergency_contact->emergency_contact_cnic : ''}}" pattern="[0-9]{5}[0-9]{7}[0-9]{1}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="emergency_contact_number[]" value="{{$emergency_contact ? $emergency_contact->emergency_contact_number : ''}}" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="emergency_contact_address[]" value="{{$emergency_contact ? $emergency_contact->emergency_contact_address : ''}}" required type="text" class="form-control">
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
                                                <input name="emergency_contact_name[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_relation[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_cnic[]" value="" pattern="[0-9]{5}[0-9]{7}[0-9]{1}" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_number[]" value="" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_address[]" value="" required type="text" class="form-control">
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
            @if($section_id && $section_id == 'emergency_contact_info_form')
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
                        <a id="5" href="#" class="btn_back btn btn-info m-btn m-btn--custom m-btn--icon" >
                            <span><i class="la la-arrow-left"></i><span>Back</span></span>
                        </a>
                    </div>
                    <div class="col-lg-6 m--align-right">
                        <button type="submit" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                            <span><span>Save & Continue</span><i class="la la-arrow-right"></i></span>
                        </button>
                        <a id="5" href="#" class="btn_skip btn btn-info m-btn m-btn--custom m-btn--icon" >
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