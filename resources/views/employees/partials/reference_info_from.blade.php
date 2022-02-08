<form action="javascript:save_employee_company_reference()" method="post" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-" id="form_step_6">
    <!--begin: Form Wizard Step 1 Body -->
    @csrf
    <input type="hidden" name="company_reference_employee_id" id="company_reference_employee_id" value="{{$employee ? $employee->employee_id : ''}}">
    <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Atlantis BPO Reference Details
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
                                            <button type="button" id="add_more_company_reference" class="btn btn-sm btn-primary">+</button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="more_company_reference_data_rows">
                                @php
                                    $company_reference_rec_count = 0;
                                @endphp
                                @if($employee_company_reference && count($employee_company_reference)>0)
                                    @foreach($employee_company_reference as $company_reference)
                                        <tr id="company_reference{{$company_reference_rec_count}}">
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <select name="company_reference[{{$company_reference_rec_count}}][reference_id]" required class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="0">External Reference</option>
                                                        @foreach($users as $user)
                                                            <option {{ ($company_reference->reference_id == $user->user_id) ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="company_reference[{{$company_reference_rec_count}}][name]" value="{{$company_reference ? $company_reference->name : ''}}"  type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="company_reference[{{$company_reference_rec_count}}][email]" value="{{$company_reference ? $company_reference->email : ''}}"  type="email" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="company_reference[{{$company_reference_rec_count}}][contact_number]" value="{{$company_reference ? $company_reference->contact_number : ''}}" type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}"  class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="company_reference[{{$company_reference_rec_count}}][company_name]" value="{{$company_reference ? $company_reference->company_name : ''}}"  type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="company_reference[{{$company_reference_rec_count}}][position]" value="{{$company_reference ? $company_reference->position : ''}}"  type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="company_reference[{{$company_reference_rec_count}}][relation]" value="{{$company_reference ? $company_reference->relation : ''}}" required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <button type="button" id="{{$company_reference_rec_count}}" class="btn btn-sm btn_remove_company_reference btn-close btn-danger">X</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $company_reference_rec_count++;
                                        @endphp
                                    @endforeach
                                @else
                                    <tr id="company_reference{{$company_reference_rec_count}}">
                                        <td>
                                            <div class="form-group m-form__group">
                                                <select name="company_reference[{{$company_reference_rec_count}}][reference_id]" required class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="0">External Reference</option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->user_id}}">{{$user->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="company_reference[{{$company_reference_rec_count}}][name]" value=""  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="company_reference[{{$company_reference_rec_count}}][email]" value=""  type="email" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="company_reference[{{$company_reference_rec_count}}][contact_number]" value=" type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="company_reference[{{$company_reference_rec_count}}][company_name]" value=""  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="company_reference[{{$company_reference_rec_count}}][position]" value=""  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="company_reference[{{$company_reference_rec_count}}][relation]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <button type="button" id="{{$company_reference_rec_count}}" class="btn btn-sm btn_remove_company_reference btn-close btn-danger">X</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <input type="hidden" id="company_reference_rec_count" value="{{$company_reference_rec_count}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--begin: Form Actions -->
    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-2 m--align-left">
                    <a id="6" href="#" class="btn_back btn btn-info m-btn m-btn--custom m-btn--icon" >
                                            <span>
                                                <i class="la la-arrow-left"></i>
                                                &nbsp;&nbsp;
                                                <span>
                                                    Back
                                                </span>
                                            </span>
                    </a>
                </div>
                <div class="col-lg-6 m--align-right">
                    <button type="submit" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                                            <span>
                                                <span>
                                                    Save & Finish
                                                </span>
                                                &nbsp;&nbsp;
                                                <i class="la la-arrow-right"></i>
                                            </span>
                    </button>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </div>
    <!--end: Form Actions -->
</form>
