<form id="staff_comments_pip" action="javascript:staff_ack_pip()" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-">
    @csrf
    <input type="hidden" name="pip_id" id="pip_id" value="{{$pip->pip_id ?? ''}}">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-check-label" for="om_comments">OM Comments </label>
                <textarea name="om_comments" class="form-control" disabled>{{$pip->om_comments ?? ''}}</textarea>
            </div>
            <div class="form-group">
                <label class="form-check-label" for="staff_comments">Staff Comments </label>
                <textarea name="staff_comments" class="form-control">{{$pip->staff_comments ?? ''}}</textarea>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-8">
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                    <a href="{{route('performance_improvement_plan')}}"  class="btn btn-primary">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>