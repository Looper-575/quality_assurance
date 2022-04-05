<div class="row">
    <div class="col-lg-12">
        <!--begin::Form-->
        <form id="notification_type_form" action="javascript:save_notification_type()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
        @csrf
        <input type="hidden" name="notification_type_id" id="notification_type_id" value="{{$notification_type ? $notification_type->notification_type_id : 0}}">
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <label class="col-lg-4 col-form-label">
                    Notification Type Name:
                </label>
                <div class="col-lg-4">
                    <input name="type" value="{{$notification_type ? $notification_type->type : ''}}"
                           required type="text" class="form-control">
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-8">
                        <button type="submit" class="btn btn-success">
                            Submit
                        </button>
                        <button type="button" class="btn btn-primary"
                                onclick="$('#background_fade').fadeOut(function() { $(this).remove(); });">
                            Back</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <!--end::Form-->
    </div>
</div>