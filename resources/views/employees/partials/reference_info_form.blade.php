<form action="javascript:save_employee_company_reference()" method="post" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-" id="reference_info_form">
    <!--begin: Form Wizard Step 1 Body -->
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Reference Details
                    </h3>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive" style="text-align: center;">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="reference_id">* Name (Atlantian Reference)</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="name">* Name</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="email">* Official Email</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="contact_number">* Contact Number</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="company_name">* Company Name</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="position">* Position</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="relation">* Relation</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="actions">Actions</label>
                                            <button type="button" onclick="add_reference_info_row(this);"
                                                    class="btn btn-sm btn-primary">+
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($employee_company_reference && count($employee_company_reference)>0)
                                    @foreach($employee_company_reference as $company_reference)
                                        <tr>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <select name="reference_id[]" required class="form-control" id="user_id" onchange="get_reference_user_data(this)">
                                                        <option value="0" {{ ($company_reference->reference_id == 0) ? 'selected' : ''}}>External Reference</option>
                                                        @foreach($employee_ref_users as $user)
                                                            <option {{ ($company_reference->reference_id == $user->user_id) ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="reference_name[]" id="reference_name" value="{{$company_reference ? $company_reference->name : ''}}" required  type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="reference_email[]" id="reference_email" value="{{$company_reference ? $company_reference->email : ''}}" required  type="email" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="reference_contact_number[]" id="reference_contact_number" value="{{$company_reference ? $company_reference->contact_number : ''}}" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}"  class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="reference_company_name[]" id="reference_company_name" value="{{$company_reference ? $company_reference->company_name : ''}}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="reference_position[]" id="reference_position" value="{{$company_reference ? $company_reference->position : ''}}" required  type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="reference_relation[]" value="{{$company_reference ? $company_reference->relation : ''}}" required type="text" class="form-control">
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
                                                <select name="reference_id[]" id="user_id" onchange="get_reference_user_data(this)" required class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="0">External Reference</option>
                                                    @foreach($employee_ref_users as $user)
                                                        <option value="{{$user->user_id}}">{{$user->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_name[]" value="" id="reference_name" required  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_email[]" value="" id="reference_email" required  type="email" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_contact_number[]" value="" id="reference_contact_number" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_company_name[]" value="" id="reference_company_name" required  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_position[]" value="" id="reference_position" required  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_relation[]" value="" required type="text" class="form-control">
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
    </div>
    <!--begin: Form Actions -->
    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
        <div class="m-form__actions">
            @if($section_id && $section_id == 'reference_info_form')
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
                        <a id="6" href="#" class="btn_back btn btn-info m-btn m-btn--custom m-btn--icon" >
                           <span><i class="la la-arrow-left"></i><span>Back</span></span>
                        </a>
                    </div>
                    <div class="col-lg-6 m--align-right">
                        <button type="submit" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                           <span><span>Save & Finish</span><i class="la la-arrow-right"></i></span>
                        </button>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
            @endif
        </div>
    </div>
    <!--end: Form Actions -->
</form>
<script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
<script>

</script>
