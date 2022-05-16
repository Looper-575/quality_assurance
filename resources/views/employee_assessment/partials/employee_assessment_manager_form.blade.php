<div class="row">
    <div class="col-6">
        <div class="form-group">
            <span class="font-bold font-14">Employee Name:</span>
            <span class="font-14">{{$EmployeeAssessment ? $EmployeeAssessment->employees->full_name : ''}}</span>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
        <span class="font-bold font-14">Designation:</span>
        <span class="font-14">{{$EmployeeAssessment ? $EmployeeAssessment->employees->designation : ''}}</span>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="font-bold font-14" for="manager_comments"><b>*  Please state his/her understanding of main duties and responsibilities.</b></label>
            <textarea type="text" required name="manager_comments" rows="3" style="width: 100%; max-width: 100%;">{{$EmployeeAssessment ? $EmployeeAssessment->manager_comments : ''}}</textarea>
            <label class="font-bold font-14" for="manager_additional_comments"><b>
                    *  Please state his/her Training and Development needs in understanding of future roles.
                    Specify training and development needs indentified during this review period.
                </b></label>
            <textarea type="text" required name="manager_additional_comments" rows="3" style="width: 100%; max-width: 100%;">{{$EmployeeAssessment ? $EmployeeAssessment->manager_additional_comments : ''}}</textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <span class="font-bold font-18">GOALS / OBJECTIVES</span>
            <p>Agree on key objectives that need to be completed before NEXT evaluation.
                Ensure that the objetives are Specific, Measurable, Achievable, Realistic, Time Bound (SMART).
                Suggest ways in which they could be achieved</p>
        </div>
        <div class="table">
            <div class="table-responsive">
                <table class="table table-bordered" style="text-align: center;">
                    <thead>
                        <tr>
                        <th rowspan="4"><span class="font-bold font-14" for="objective">Description of Objectives</span></th>
                        <th rowspan="4"><span class="font-bold font-14" for="measurement_index">How will the Objectives be Measured</span></th>
                        <th rowspan="2"><span class="font-bold font-14" for="remarks">Achievement Remarks</span></th>
                        <th rowspan="2"><span class="font-bold font-14" for="timeline">Timeline</span></th>
                        <th rowspan="2"><span class="font-bold font-14" for="actions">Actions</span> <br>
                                <button type="button" onclick="add_obj_row(this)"
                                        class="btn btn-sm btn-primary add_obj_row">+
                                </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($employee_previous_objectives)
                        @foreach($employee_previous_objectives as $objective)
                            <tr>
                                <td><span class="font-14" for="previous_objective">{{$objective ? $objective->objective : ''}}</span>
                                    <input type="hidden" name="previous_objective_id[]" value="{{$objective ? $objective->id : ''}}">
                                </td>
                                <td><span class="font-14" for="previous_measurement_index">{{$objective ? $objective->measurement_index : ''}}</span></td>
                                <td><input name="previous_remarks[]" value="{{$objective ? $objective->remarks : ''}}" required
                                               type="text" class="form-control"></td>
                                <td><span class="font-14" for="previous_timeline">{{$objective ? $objective->timeline : ''}}</span></td>
                                <td><span class="font-14">Update Previous Evaluation Objectives Remarks</span></td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td><input name="objective[]" value="" type="text" class="form-control"></td>
                        <td><input name="measurement_index[]" value="" type="text" class="form-control"></td>
                        <td><input name="remarks[]" value="" type="text" class="form-control"></td>
                        <td><input name="timeline[]" value="" type="text" placeholder="in days/months"
                                       class="form-control"></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<hr>
<script>
    function add_obj_row(me) {
        let obj_tr = (function () {/*<tr>
                    <td><input name="objective[]" value="" required type="text" class="form-control"></td>
                    <td><input name="measurement_index[]" value="" required type="text" class="form-control"></td>
                    <td><input name="remarks[]" value="" required type="text" class="form-control"></td>
                    <td><input name="timeline[]" value="" required type="text" placeholder="in days/months" class="form-control"></td>
                    <td> <button type="button" onclick="remove_row(this);"
                                    class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                            </button></td>
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