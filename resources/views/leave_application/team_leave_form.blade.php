@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Team leave Application form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div id="remaining_leaves_bucket"></div>
            <form class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data" method="post" id="leave_form">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            @if($leave)
                                <input type="hidden" value="{{$leave->leave_id}}" name="leave_id">
                            @endif
                            <label class="form-check-label" for="leave_type">Leave Type</label>
                            <select class="form-control" name="leave_type"  id="leave_type" required >
                                <option value="" selected disabled >Select</option>
                                @foreach($leave_types as $leave_type)
                                    <option {{$leave ? ($leave->leave_type_id == $leave_type->leave_type_id ? 'selected' : '' ): ''}}
                                            value="{{$leave_type->leave_type_id}}">{{$leave_type->title}}</option>
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
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="team_member">Team Members</label>
                            <select class="form-control" name="team_member" id="team_member" required>
                                <option value="">Select</option>
                                @foreach($agents->team_member as $agent)
                                    <option value="{{$agent->user->user_id}}">{{$agent->user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                </div>
                <div class="row">
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
        let remaining_leaves_div_html = (function () {/*<div class="row">
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
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];

        $('#team_member').change(function() {
            let team_member_id = $('#team_member').val();
            $.ajax({
                type: 'post',
                url: '{{route('get_employee_leaves_bucket')}}',
                data: {_token:"{{csrf_token()}}",team_member_id: team_member_id},
                success: function( data ) {
                    let remaining_leaves_div = $(remaining_leaves_div_html);
                    remaining_leaves_div.find('tbody').find('tr').append('<td id="remaining_annual">'+data.remaining_annual+'</td>');
                    remaining_leaves_div.find('tbody').find('tr').append('<td id="remaining_casual">'+data.remaining_casual+'</td>');
                    remaining_leaves_div.find('tbody').find('tr').append('<td id="remaining_sick">'+data.remaining_sick+'</td>');
                    $('#remaining_leaves_bucket').html(remaining_leaves_div);
                }
            });
        });

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
            $('#from').attr('min', maxDate);
            $('#to').attr('min', maxDate);
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
            call_ajax_with_functions('','{{route('team_leave_save')}}',data,arr);
        });

        function dateDifference(){
            var from_date = $('#from').val();
            var to_date = $('#to').val();
            from_date = from_date.split('-');
            to_date = to_date.split('-');
            from_date = new Date(from_date[0], from_date[1], from_date[2]);
            to_date = new Date(to_date[0], to_date[1], to_date[2]);
            from_date_unixtime = parseInt(from_date.getTime() / 1000);
            to_date_unixtime = parseInt(to_date.getTime() / 1000);
            var timeDifference =    to_date_unixtime - from_date_unixtime;
            var timeDifferenceInHours = timeDifference / 60 / 60;
            var timeDifferenceInDays = timeDifferenceInHours  / 24;
            $('#no_leaves').val(timeDifferenceInDays + 1 );

            let days = $('#no_leaves').val()
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
    </script>
@endsection
