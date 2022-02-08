<form action="javascript:save_employee_education()" method="post" enctype="multipart/form-data"
      class="m-form m-form--label-align-left- m-form--state-" id="education_info_form">
    <!--begin: Form Wizard Step 1 Body -->
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Education Details
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
                                            <label for="degree">* Degree</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="institute_name">* Institute Name</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="division_grade">* Division/Grade</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="major_subjects">* Major Subjects</label>
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
                                            <label for="actions">Actions</label> <br>
                                            <button type="button" onclick="add_edu_row(this)"
                                                    class="btn btn-sm btn-primary add_edu_row">+
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($employee_education && count($employee_education)>0)
                                    @foreach($employee_education as $education)
                                        <tr>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="education_degree[]"
                                                           value="{{$education ? $education->degree : ''}}" required
                                                           type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="education_institute_name[]"
                                                           value="{{$education ? $education->institute_name : ''}}"
                                                           required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="education_division_grade[]"
                                                           value="{{$education ? $education->division_grade : ''}}"
                                                           required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <input name="education_major_subjects[]"
                                                           value="{{$education ? $education->major_subjects : ''}}"
                                                           required type="text" class="form-control">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group d-flex">
                                                    <input name="education_from_date[]"
                                                           value="{{$education ? $education->from_date : ''}}"
                                                           required type="date" class="form-control">
                                                    <input name="education_to_date[]"
                                                           value="{{$education ? $education->to_date : ''}}"
                                                           required type="date" class="form-control">
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
                                                <input name="education_degree[]" value="" required type="text"
                                                       class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="education_institute_name[]" value="" required type="text"
                                                       class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="education_division_grade[]" value="" required type="text"
                                                       class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="education_major_subjects[]" value="" required type="text"
                                                       class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group d-flex">
                                                <input name="education_from_date[]" value="" required type="date"
                                                       class="form-control" placeholder="from date">
                                                <input name="education_to_date[]" value="" required type="date"
                                                       class="form-control" placeholder="to date">
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
            </div>
        </div>
    </div>
    <!--begin: Form Actions -->
    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
        <div class="m-form__actions">
            @if($section_id && $section_id == 'education_info_form')
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2 m--align-left"> </div>
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
                        <a id="2" href="#" class="btn_back btn btn-info m-btn m-btn--custom m-btn--icon">
                            <span><i class="la la-arrow-left"></i><span>Back</span></span>
                        </a>
                    </div>
                    <div class="col-lg-6 m--align-right">
                        <button type="submit" class="btn btn-warning m-btn m-btn--custom m-btn--icon">
                            <span><span>Save & Continue</span><i class="la la-arrow-right"></i></span>
                        </button>
                        <a id="2" href="#" class="btn_skip btn btn-info m-btn m-btn--custom m-btn--icon">
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
