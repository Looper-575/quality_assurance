<form id="initiate_employee_assessment_form" action="javascript:employee_assessment_initiate()" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-">
    @csrf
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="font-bold font-14" for="user_id">Employee Name<span class="text-danger">*</span></label>
                <select class="form-control" name="user_id" id="user_id" required >
                    <option value="">Select</option>
                    @foreach($users as $user)
                        <option value="{{$user->user_id}}">{{$user->full_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6"></div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-bold font-14" for="from_date">From Date<span class="text-danger">*</span></label>
                <input  class="form-control" name="from_date" id="from_date_id" value="" type="date">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-bold font-14" for="to_date">To Date<span class="text-danger">*</span></label>
                <input  class="form-control" name="to_date" id="to_date" value="" type="date" max="">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input type="submit" class="btn btn-success  float-right" name="submit" value="Submit">
            <a href="#" onclick="$('#background_fade').fadeOut(function() { $(this).remove(); });" class="btn btn-primary float-right mr-2">Close</a>
        </div>
    </div>
</form>
