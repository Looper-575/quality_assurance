@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Check Attendance</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="check_attendance_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label" for="attendance_date" >Attendance Date</label>
                            <input class="form-control mt-3" type="date" name="attendance_date" value="" id="attendance_date" required>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label" for="manager_id">Team</label>
                            <input type="hidden" name="manager_id" value="{{Auth::user()->user_id}}" id="manager_id" {{ Auth::user()->role->role_id == 1 ? 'disabled' : '' }}>
                            <select class="form-control select2 mt-3" name="manager_id" id="manager_id" required {{ Auth::user()->role->role_id == 1 ||   Auth::user()->role->role_id==5 ? '' : 'disabled' }}>
                                <option value="">Select Team</option>
                                @foreach($teams as $team)
                                    <option {{ Auth::user()->user_id == $team->team_lead_id ? 'selected' : '' }} value="{{$team->team_lead_id}}">{{$team->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mt-4">
                        <button type="submit"  class="btn btn-primary float-right py-2 mt-3"> Check Attendance</button>
                    </div>
                </div>
            </form>
            <div id="mark_attendance_table_id" class="mt-5" style="width: 100%"></div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function (){
            var today = new Date().toISOString().split("T")[0];
            three_day_ago = new Date();
            days = 86400000; //number of milliseconds in a day
            var last_three_day = new Date(three_day_ago - (3*days));
            last_three_day = last_three_day.toISOString().split("T")[0];
            $('#attendance_date').attr('max', today);
            <?php if(Auth::user()->role_id != 1 && Auth::user()->role_id != 5){ ?>
            $('#attendance_date').attr('min', last_three_day);
            <?php } ?>
        });
        $('#check_attendance_form').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('check_attendance_form');
            let data = new FormData(form);
            let a = function() {
                // window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('mark_attendance_table_id', '{{route('check_back_date_attendance')}}', data, arr);
        });
        function create_attendance(){
            let form = document.getElementById('check_attendance_form');
            let data = new FormData(form);
            let a = function() {
                // window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('mark_attendance_table_id', '{{route('creat_back_date_attendance')}}', data, arr);
        }
        // show current and future dates
        function time_out_set(){
            var time_out_set = new Date();
            var hour = time_out_set.getHours() + 1;
            var mint = time_out_set.getMinutes();
            console.log('Check time out == ', time_out_set,hour, mint);
            return false;
            var year = time_out_set.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            $('#from').attr('min', maxDate);
            $('#to').attr('min', maxDate);
        };
        function time_in(e) {
            var user_id = e;
            var time_in = $("#time_in_"+user_id).val();
            var row_id = $("#row_"+user_id).val();
            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: user_id,
                    time_in: time_in,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function time_out(e) {
            var user_id = e;
            var time_in = $("#time_in_"+user_id).val();
            var time_out = $("#time_out_"+user_id).val();
            var row_id = $("#row_"+user_id).val();
            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: user_id,
                    time_out: time_out,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                    toastr.success('Updated Successfully!');
                }
            });
        }
        function mark_on_leave(e) {
            var id = e;
            var row_id = $("#row_"+id).val();
            var on_leave = '';
            if($("#on_leave_"+id).is(':checked') == true){
                on_leave = 1;
            }
            else{
                on_leave = 0;
            }
            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    on_leave: on_leave,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function mark_half_leave(e) {
            var id = e;
            var row_id = $("#row_"+id).val();
            var half_leave = '';
            if($("#half_leave_"+id).is(':checked') == true){
                half_leave = 1;
            }
            else{
                half_leave = 0;
            }
            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    half_leave: half_leave,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function mark_late(e) {
            var id = e;
            var row_id = $("#row_"+id).val();

            var late = '';
            if($("#late_"+id).is(':checked') == true){
                late = 1;
                $("#absent_"+id).prop("checked", false);
                $("#absent_"+id).prop("disabled", true);
            }
            else{
                late = 0;
                $("#absent_"+id).prop("disabled", false);
            }
            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    late: late,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    toastr.success('Updated Successfully!')
                }
            });
        }
        function mark_absent(e) {
            var id = e;
            var row_id = $("#row_"+id).val();

            var absent = '';
            if($("#absent_"+id).is(':checked') == true){
                $("#time_in_"+id).val('');
                $("#time_out_"+id).val('');

                absent = 1;
                $("#late_"+id).prop("checked", false);
                $("#late_"+id).prop("disabled", true);
            }
            else{
                absent = 0;
                $("#late_"+id).prop("disabled", false);
            }

            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    absent: absent,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                    toastr.success('Updated Successfully!')
                }
            });

        }
    </script>
@endsection
