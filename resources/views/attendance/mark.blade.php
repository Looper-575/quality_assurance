@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Mark Attendance</h3>
                </div>
                @if(count($teams)>0)
                <div class="m-portlet__head-title float-right">
                    <select class="form-control select2 mt-3" name="manager_id" id="manager_id">
                        <option value="">Select Manager</option>
                        @foreach($teams as $team)
                            <option value="{{$team->team_lead_id}}">{{$team->title}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body" id="mark_attendance_table_id">
            <div style="width: 100%">
                @if($agents)
                <table class="datatable table table-bordered" id="mark_tid" style="width:100%">
                    <thead>
                    <tr>
                        <th>Agent Name</th>
{{--                        <th>Email</th>--}}
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th title="Field #10">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($agents as $agent_list)
                            <tr>
                                <input type="hidden" name="attendance_id" value="{{$agent_list->attendance_id}}" id="row_{{@$agent_list->user->user_id}}">
                                <td>{{ @$agent_list->user->full_name }}</td>
{{--                                <td>{{ @$agent_list->user->email }}</td>--}}
                                <td>{{ $agent_list->attendance_date }}</td>
                                <td>
                                    <input class="form-control" type="time" onchange="time_in({{@$agent_list->user->user_id}})" name="time_in" value="{{$agent_list->time_in}}" id="time_in_{{@$agent_list->user->user_id}}" {{  ($agent_list->applied_leave == 1 ? ' disabled' : '') }}>
                                </td>
                                <td>
                                    <input class="form-control" type="time" name="time_out" onchange="time_out({{@$agent_list->user->user_id}})" value="{{$agent_list->time_out}}" id="time_out_{{@$agent_list->user->user_id}}" {{  ($agent_list->applied_leave == 1 ? ' disabled' : '') }}>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <?php
                                        $check_leave_bucket = get_leave_bucket_leaves(@$agent_list->user->user_id);
                                        ?>
                                        <span class="mr-5">
                                            Casual: {{$check_leave_bucket['remaining_casual']}}
                                            Sick: {{$check_leave_bucket['remaining_sick']}}
                                        </span>
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="on_leave_{{@$agent_list->user->user_id}}"
                                            onclick="mark_on_leave({{@$agent_list->user->user_id}})"
                                            id="on_leave_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->on_leave == 1 ? ' checked' : '') }}
                                            {{ ($agent_list->applied_leave == 1 ? ' checked' : '') }}
                                            {{  ($agent_list->applied_leave == 1 ? ' disabled' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="on_leave_{{@$agent_list->user->user_id}}"> On Leave</label>
                                       <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="half_leave_{{@$agent_list->user->user_id}}"
                                            onclick="mark_half_leave({{@$agent_list->user->user_id}})"
                                            id="half_leave_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->half_leave == 1 ? ' checked' : '') }}
                                            {{  ($agent_list->applied_leave == 1 ? ' disabled' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="half_leave_{{@$agent_list->user->user_id}}"> Half Leave</label>
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="agent_attendance_{{@$agent_list->user->user_id}}"
                                            onclick="mark_late({{@$agent_list->user->user_id}})"
                                            id="late_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->late == 1 ? ' checked' : '') }}
                                            {{  ($agent_list->absent == 1 ? ' disabled' : '') }}
                                            {{  ($agent_list->applied_leave == 1 ? ' disabled' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="late_{{@$agent_list->user->user_id}}"> Late</label>
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            onclick="mark_absent({{@$agent_list->user->user_id}})"
                                            name="agent_attendance_{{@$agent_list->user->user_id}}"
                                            id="absent_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->absent == 1 ? ' checked' : '') }}
                                            {{  ($agent_list->late == 1 ? ' disabled' : '') }}
                                            {{  ($agent_list->applied_leave == 1 ? ' disabled' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="absent_{{@$agent_list->user->user_id}}">Absent</label>
                                    </div>
                                </td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            // $('#mark_tid').DataTable({ columnDefs: [ { goals: [2]  }]  });
            $('input.timepicker').timepicker({
                timeFormat: 'HH:mm:ss',
                minTime: '05:00:00', // 11:45:00 AM,
                // maxHour: 20,
                // maxMinutes: 30,
                startTime: new Date(0,0,0,17,0,0), // 3:00:00 PM - noon
                // interval: 15, // 15 minutes
            });
        } );
        $('#manager_id').on('change', function() {
            var manager_id = $(this).val();
            var url = '{{ route("get_manager_attendance",":id") }}';
            url = url.replace(':id',manager_id);
            $.ajax({
                type:'get',
                url:url,
                success: function( resp ) {
                    document.getElementById('mark_attendance_table_id').innerHTML = resp;
                }
            });
        });
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
                $("#time_out_"+id).val('');
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
