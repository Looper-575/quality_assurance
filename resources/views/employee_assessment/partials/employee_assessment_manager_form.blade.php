<div class="row">
    <div class="col-6">
        <div class="form-group m-form__group">
            <label for="name"><b>Employee Name:</b> </label>
            <label for="name">{{$EmployeeAssessment ? $EmployeeAssessment->employees->full_name : ''}}</label>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group m-form__group">
            <label for="designation"><b>Designation:</b> </label>
            <label for="designation">{{$EmployeeAssessment ? $EmployeeAssessment->employees->designation : ''}}</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group m-form__group">
            <label for="manager_comments"><b>*  Please state his/her understanding of main duties and responsibilities.</b></label>
            <textarea type="text" required name="manager_comments" rows="6" style="width: 100%; max-width: 100%;">{{$EmployeeAssessment ? $EmployeeAssessment->manager_comments : ''}}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group m-form__group text-left">
            <label for="manager_additional_comments"><b>
                    *  Please state his/her Training and Development needs in understanding of future roles.
                    Specify training and development needs indentified during this review period.
                </b></label>
            <textarea type="text" required name="manager_additional_comments" rows="6" style="width: 100%; max-width: 100%;">{{$EmployeeAssessment ? $EmployeeAssessment->manager_additional_comments : ''}}</textarea>
        </div>
    </div>
</div>
<div class="m-separator m-separator--dashed m-separator--lg"></div>
<div class="m-form__section">
    <div class="m-form__heading">
        <h3 class="m-form__heading-title">
            GOALS / OBJECTIVES
        </h3>
        <p>Agree on key objectives that need to be completed before NEXT evaluation.
            Ensure that the objetives are Specific, Measurable, Achievable, Realistic, Time Bound (SMART).
            Suggest ways in which they could be achieved</p>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered" style="text-align: center;">
                    <thead>
                    <tr>
                        <th rowspan="4">
                            <div class="form-group m-form__group">
                                <label for="objective">Description of Objectives</label>
                            </div>
                        </th>
                        <th rowspan="4">
                            <div class="form-group m-form__group">
                                <label for="measurement_index">How will the Objectives be Measured</label>
                            </div>
                        </th>
                        <th rowspan="2">
                            <div class="form-group m-form__group">
                                <label for="remarks">Achievement Remarks</label>
                            </div>
                        </th>
                        <th rowspan="2">
                            <div class="form-group m-form__group">
                                <label for="timeline">Timeline</label>
                            </div>
                        </th>
                        <th rowspan="2">
                            <div class="form-group m-form__group">
                                <label for="actions">Actions</label> <br>
                                <button type="button" onclick="add_obj_row(this)"
                                        class="btn btn-sm btn-primary add_obj_row">+
                                </button>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($employee_previous_objectives)
                        @foreach($employee_previous_objectives as $objective)
                    <tr>
                        <td>
                            <div class="form-group m-form__group">
                                <label for="previous_objective">{{$objective ? $objective->objective : ''}}</label>
                                <input type="hidden" name="previous_objective_id[]" value="{{$objective ? $objective->id : ''}}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group m-form__group">
                                <label for="previous_measurement_index">{{$objective ? $objective->measurement_index : ''}}</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group m-form__group">
                                <input name="previous_remarks[]" value="{{$objective ? $objective->remarks : ''}}" required
                                       type="text" class="form-control">
                            </div>
                        </td>
                        <td>
                            <div class="form-group m-form__group">
                                <label for="previous_timeline">{{$objective ? $objective->timeline : ''}}</label>
                            </div>
                        </td>
                        <td><h6>Update Previous Evaluation Objectives Remarks</h6></td>
                    </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td>
                            <div class="form-group m-form__group">
                                <input name="objective[]" value="" type="text" class="form-control">
                            </div>
                        </td>
                        <td>
                            <div class="form-group m-form__group">
                                <input name="measurement_index[]" value="" type="text" class="form-control">
                            </div>
                        </td>
                        <td>
                            <div class="form-group m-form__group">
                                <input name="remarks[]" value="" type="text" class="form-control">
                            </div>
                        </td>
                        <td>
                            <div class="form-group m-form__group">
                                <input name="timeline[]" value="" type="text" placeholder="in days/months"
                                       class="form-control">
                            </div>
                        </td>
                        <td>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function add_obj_row(me) {
        let obj_tr = (function () {/*<tr>
                    <td>
                        <div class="form-group m-form__group">
                            <input name="objective[]" value="" required type="text" class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="form-group m-form__group">
                            <input name="measurement_index[]" value="" required type="text" class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="form-group m-form__group">
                            <input name="remarks[]" value="" required type="text" class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="form-group m-form__group">
                            <input name="timeline[]" value="" required type="text" placeholder="in days/months" class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="form-group m-form__group">
                            <button type="button" onclick="remove_row(this);"
                                    class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                            </button>
                        </div>
                    </td>
                </tr>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        let tr = $(obj_tr);
        $(me).closest('table').find('tbody').append(tr);
        $(me).closest('table').find('tbody').find('tr').fadeIn('slow');
    }
    // remove button for all added tr's
    function remove_row(me) {
        $(me).closest('tr').fadeOut('slow', function (){
            this.remove();
        })
    }
</script>