<form id="employee_comments_pip" action="javascript:employee_ack_pip()" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-">
    @csrf
    <input type="hidden" name="pip_id" id="pip_id" value="{{$pip->pip_id ?? ''}}">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-check-label" for="manager_comments">Manager Comments </label>
                <textarea name="manager_comments" class="form-control" disabled>{{$pip->manager_comments ?? ''}}</textarea>
            </div>
            <div class="form-group">
                <label class="form-check-label" for="employee_comments">Employee Comments </label>
                <textarea name="employee_comments" class="form-control">{{$pip->employee_comments ?? ''}}</textarea>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="row">
                <div class="col-12 text-right">
                    <a onclick="$('#background_fade').fadeOut(function() { $(this).remove(); });" class="btn btn-primary text-white">Close</a>
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                </div>
            </div>
    </div>
</form>
