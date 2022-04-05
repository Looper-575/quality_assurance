<form action="javascript:save_employee_docs()" method="post" enctype="multipart/form-data"
      class="m-form m-form--label-align-left- m-form--state-" id="upload_docs_form">
    <!--begin: Form Wizard Step 1 Body -->
    @csrf
    <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Upload Documents
                    </h3>
                    <p>Please upload your educational and experience certificates.</p>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="text-align: center;">
                                <thead>
                                <tr>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="doc_title">* Doc Title</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="doc_file">* Doc File</label>
                                        </div>
                                    </th>
                                    <th rowspan="2">
                                        <div class="form-group m-form__group">
                                            <label for="actions">Actions</label> <br>
                                            <button type="button" onclick="add_doc_row(this)"
                                                    class="btn btn-sm btn-primary add_doc_row">+
                                            </button>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($employee_docs && count($employee_docs)>0)
                                    @foreach($employee_docs as $doc)
                                        <tr>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <span>{{$doc ? $doc->doc_title : ''}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group m-form__group">
                                                    <a href="{{asset('employee_documents/'.$doc->doc_file)}}" target="_blank">
                                                        <span><i class="fa fa-file-pdf" style='color: red'></i><span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                @if($loop->index > 0)
                                                    <div class="form-group m-form__group">
                                                        <button type="button" onclick="remove_row(this);" id="{{$doc->id}}"
                                                                class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($loop->index == 0)
                                            <tr>
                                                <td>
                                                    <div class="form-group m-form__group">
                                                        <input name="doc_title[]"
                                                               value="" required
                                                               type="text" class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group m-form__group">
                                                        <input name="doc_file[]" accept="application/pdf" required type="file" class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="doc_title[]"
                                                       value="" required
                                                       type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="doc_file[]" accept="application/pdf" required type="file" class="form-control">
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
            @if($section_id && $section_id == 'upload_docs_form')
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
                        <a id="7" href="#" class="btn_back btn btn-info m-btn m-btn--custom m-btn--icon">
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
