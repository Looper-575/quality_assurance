@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">leave Application form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Remaining Annual Leaves</th>
                            <th>Remaining Casual Leaves</th>
                            <th>Remaining Sick Leaves</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $check_leave_bucket = get_leave_bucket_leaves(Auth::user()->user_id);
                                ?>
                                <td id="remaining_annual">{{$check_leave_bucket['remaining_annual']}}</td>
                                <td id="remaining_casual">{{$check_leave_bucket['remaining_casual']}}</td>
                                <td id="remaining_sick">{{$check_leave_bucket['remaining_sick']}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <form class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data" method="post" id="leave_form" action="{{route('leave_save')}}">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            @if($leave)
                                <input type="hidden" value="{{$leave->leave_id}}" name="leave_id">
                            @endif
                            <label class="form-check-label" for="leave_type">Leave Type</label>
                            <select class="form-control" name="leave_type" id="leave_type" required >
                                <option value="" selected disabled >Select</option>
                                @foreach($leave_types as $leave_type)
                                    <option {{$leave ? ($leave->leave_type_id == $leave_type->leave_type_id ? 'selected' : '' ): ''}}
                                           {{($check_leave_bucket['remaining_annual']<1 ? ($leave_type->leave_type_id == 1 ? 'disabled' : '') : '')}} {{($check_leave_bucket['remaining_casual']<1 ? ($leave_type->leave_type_id == 2 ? 'disabled' : '') : '')}} {{($check_leave_bucket['remaining_sick']<1 ? ($leave_type->leave_type_id == 3 ? 'disabled' : '') : '')}} value="{{$leave_type->leave_type_id}}">{{$leave_type->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" id="half_day" style="display: none" >
                            <label for="half_day" class="form-check-label">Select Half Day</label>
                            <select class="form-control" name="half" id="half_day_option">
                                <option value="" selected disabled>Select</option>
                                <option value="first_half" {{$leave?($leave->half_type == 'first_half' ? 'selected':''):''}}>First Half</option>
                                <option value="second_half" {{$leave?($leave->half_type == 'second_half' ? 'selected':''):''}}>Second Half</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group ">
                            <label class="form-check-label" for="from">From </label>
                            <input value="{{$leave ? $leave->from:''}}" required  type="date"  class="form-control" name="from" id="from" >
                        </div>
                    </div>
                    <div class="col-6" id="to_date">
                        <div class="form-group ">
                            <label class="form-check-label" for="to">To </label>
                            <input value="{{$leave ? $leave->to:''}}" required  type="date"  class="form-control" name="to"  id="to" >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" id="sick_report" >
                            <label class="form-check-label" for="medical_report">Attachement / Mecdical Report</label>
                            <input type="file" class="form-control" name="medical_report" id="medical_report">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" id="no_of_leaves">
                            <label  class="form-check-label" for="no_leaves">No of Leaves</label>
                            <input value="{{$leave ? $leave->no_leaves:''}}"  type="number" class="form-control" name="no_leaves"  id="no_leaves" readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="reason"> Reason </label>
                            <textarea   class="form-control " required name="reason" id="reason"  rows="3">{{$leave ? $leave->reason:''}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary"> Submit </button>
                            <button type="reset" class="btn btn-danger"> Reset </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        if($('#leave_type').val() == 3 && $('#no_leaves').val() > 2 ) {
            $("#medical_report").attr("required", true);
        }
        else{
            $("#medical_report").removeAttr('required');
        }

        if($('#leave_type').val() == 4) {
            $("#medical_report").removeAttr("required");
            $('#half_day').fadeIn();
            $('#half_day_option').attr('required', true);
            $('#no_leaves').removeAttr('required');
            $('#to_date').fadeOut();
            $("#to").removeAttr("required");
            $('#to').val('');
            $('#no_leaves').val(" ");
            @if($leave && $leave->half_type != NULL)
            $('#half_day_option').val('{{$leave->half_type}}').attr("selected", "selected");
            @endif
        }
        else {
            $('#to').attr('required', true);
        }

        // if($('#leave_type').val() == 3 && $('#no_leaves').val() > 2 ) {
        //     $("#medical_report").attr("required", true);
        // }
        // else{
        //     $("#medical_report").removeAttr("required");
        // }

        // show current and future dates
        $(function(){
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            // $('#from').attr('min', maxDate);
            // $('#to').attr('min', maxDate);
        });

        $('#from').change(function(){
            var date = new Date($('#from').val());
            let day = date.getDate();
            let month = date.getMonth()+1;
            let year = date.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            $('#to').attr('min', maxDate);

            if($("#to").val() !=="" && $("#to").val() <= $("#from").val() )
            {
                $("#to").val(maxDate);
            }
            if($('#leave_type').val() == 3 && $('#no_leaves').val() > 2 ) {
                $("#medical_report").attr("required", true);
            }
            else{
                $("#medical_report").removeAttr('required');
            }
            dateDifference();
        });
        $('#leave_type').change(function (){
            if($(this).val() == 3 && $('#no_leaves').val() > 2 ) {
                $("#medical_report").attr("required", true);
                $('#half_day').fadeOut();
                $('#half_day_option').removeAttr('required');
                $('#half_day_option').val('');
                $('#to_date').fadeIn();
                $('#to').attr('required',true);
            } else if($(this).val() == 4) {
                $("#medical_report").removeAttr("required");
                $('#half_day').fadeIn();
                $('#half_day_option').attr('required' , true);
                $('#no_leaves').removeAttr('required');
                $('#no_leaves').val(" ");
                $('#to_date').fadeOut();
                $("#to").removeAttr("required");
                $('#to').val('');
            }
            else {
                $("#medical_report").removeAttr('required');
                $('#half_day').fadeOut();
                $('#half_day_option').removeAttr('required');
                $('#to_date').fadeIn();
                $('#half_day_option').val('');
                $('#to').attr('required',true);
            }
        });


        $('#to').change(function (){
            dateDifference();
            if($('#leave_type').val() == 3 && $('#no_leaves').val() > 2 ) {
                $("#medical_report").attr("required", true);
            }
            else{
                $("#medical_report").removeAttr('required');
            }
        });
        $('#leave_form').submit(function (e){
            e.preventDefault();
            let data = new FormData(this);
            let a = function () {
                window.location.href = "{{route('leave_list')}}";
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('leave_save')}}',data,arr);
        });

        function dateDifference(){
            var from_date = new Date($('#from').val());
            var to_date = new Date($('#to').val());
            let days = DaysBetween(from_date,to_date);
            $('#no_leaves').val(days);
            let annual = $('#remaining_annual').text();
            let casual = $('#remaining_casual').text();
            let sick = $('#remaining_sick').text();
            let leave_type_val = $('#leave_type').val();
            if(leave_type_val == 1 && annual<days){
                swal({
                    title: "Warning!",
                    text: "Please check you Annual leave limit",
                    type: "warning",
                    timer: 2000,
                    button: false,
                });
                $('#to').val('');
                $('#no_leaves').val('');
            }
            if(leave_type_val == 2 && casual<days){
                swal({
                    title: "Warning!",
                    text: "Please check you Casual leave limit",
                    type: "warning",
                    timer: 3000,
                    button: false,
                });
                $('#to').val('');
                $('#no_leaves').val('');
            }
            if(leave_type_val == 3 && sick<days){
                swal({
                    title: "Warning!",
                    text: "Please check you Sick leave limit",
                    type: "warning",
                    timer: 3000,
                    button: false,
                });
                $('#to').val('');
                $('#no_leaves').val('');
            }
        }

        function DaysBetween(dDate1, dDate2) {
            if(dDate1.getDate()===dDate2.getDate()){
                return 1;
            }
            var iWeeks, iDateDiff, iAdjust = 0;
            if (dDate2 < dDate1) return -1; // error code if dates transposed
            var iWeekday1 = dDate1.getDay(); // day of week
            var iWeekday2 = dDate2.getDay();
            iWeekday1 = (iWeekday1 == 0) ? 7 : iWeekday1; // change Sunday from 0 to 7
            iWeekday2 = (iWeekday2 == 0) ? 7 : iWeekday2;
            if ((iWeekday1 > 5) && (iWeekday2 > 5)) iAdjust = 1; // adjustment if both days on weekend
            iWeekday1 = (iWeekday1 > 5) ? 5 : iWeekday1; // only count weekdays
            iWeekday2 = (iWeekday2 > 5) ? 5 : iWeekday2;
            // calculate differnece in weeks (1000mS * 60sec * 60min * 24hrs * 7 days = 604800000)
            iWeeks = Math.floor((dDate2.getTime() - dDate1.getTime()) / 604800000)
            if (iWeekday1 < iWeekday2) { //Equal to makes it reduce 5 days
                iDateDiff = (iWeeks * 5) + (iWeekday2 - iWeekday1)
            } else {
                iDateDiff = ((iWeeks + 1) * 5) - (iWeekday1 - iWeekday2)
            }
            iDateDiff -= iAdjust // take into account both days on weekend
            return (iDateDiff + 1); // add 1 because dates are inclusive
        }
        // function DaysBetween(StartDate, EndDate) {
        //     // The number of milliseconds in all UTC days (no DST)
        //     const oneDay = 1000 * 60 * 60 * 24;
        //
        //     // A day in UTC always lasts 24 hours (unlike in other time formats)
        //     const start = Date.UTC(EndDate.getFullYear(), EndDate.getMonth(), EndDate.getDate());
        //     const end = Date.UTC(StartDate.getFullYear(), StartDate.getMonth(), StartDate.getDate());
        //
        //     // so it's safe to divide by 24 hours
        //     return (start - end) / oneDay;
        // }
    </script>
@endsection
