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
                <div class="m-portlet__head-title float-right">
                    <select class="form-control select2 mt-3" name="manager_id" id="manager_id">
                        <option value="">Select Manager</option>
                        @foreach($managers as $agent)
                            <option value="{{$agent->user_id}}">{{@$agent->full_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="m-portlet__body" id="mark_attendance_table_id">
            <div style="width: 100%">
                @if($agents)
                    <table class="datatable table table-bordered" id="mark_tid" style="width:100%">
                        <thead>
                        <tr>
                            <th>Agent Name</th>
                            <th>Email</th>
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
                                <td>{{ @$agent_list->user->email }}</td>
                                <td>{{ $agent_list->attendance_date }}</td>
                                <td>
                                    <input class="form-control" type="time" onchange="time_in({{@$agent_list->user->user_id}})" name="time_in" value="{{$agent_list->time_in}}" id="time_in_{{@$agent_list->user->user_id}}">
                                </td>
                                <td>
                                    <input class="form-control" type="time" name="time_out" onchange="time_out({{@$agent_list->user->user_id}})" value="{{$agent_list->time_out}}" id="time_out_{{@$agent_list->user->user_id}}" >
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="half_leave_{{@$agent_list->user->user_id}}"
                                            onclick="mark_on_leave({{@$agent_list->user->user_id}})"
                                            id="on_leave_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->on_leave == 1 ? ' checked' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="on_leave_{{@$agent_list->user->user_id}}"> On Leave</label>

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="half_leave_{{@$agent_list->user->user_id}}"
                                            onclick="mark_half_leave({{@$agent_list->user->user_id}})"
                                            id="half_leave_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->half_leave == 1 ? ' checked' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="half_leave_{{@$agent_list->user->user_id}}"> Half Day</label>

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="agent_attendance_{{@$agent_list->user->user_id}}"
                                            onclick="mark_late({{@$agent_list->user->user_id}})"
                                            id="late_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->late == 1 ? ' checked' : '') }}
                                            {{  ($agent_list->absent == 1 ? ' disabled' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="late_{{@$agent_list->user->user_id}}"> Late</label>

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            onclick="mark_absent({{@$agent_list->user->user_id}})"
                                            name="agent_attendance_{{@$agent_list->user->user_id}}"
                                            id="absent_{{@$agent_list->user->user_id}}"
                                            {{  ($agent_list->absent == 1 ? ' checked' : '') }}
                                            {{  ($agent_list->late == 1 ? ' disabled' : '') }}
                                        /><label class="form-check-label pr-4 mt-1" for="absent_{{@$agent_list->user->user_id}}">Absent</label>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h4>No one available in your team to mark attendance. You can check other teams.</h4>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $('#manager_id').on('change', function() {
            let manager_id = $(this).val();
            let url = '{{ route("get_manager_attendance",":id") }}';
            url = url.replace(':id',manager_id);
            $.ajax({
                type:'get',
                url:url,
                success: function( resp ) {
                    document.getElementById('mark_attendance_table_id').innerHTML = resp;
                }
            });
        });
        function time_in(e) {
            let user_id = e;
            let time_in = $("#time_in_"+user_id).val();
            let row_id = $("#row_"+user_id).val();
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
            let user_id = e;
            let time_in = $("#time_in_"+user_id).val();
            let time_out = $("#time_out_"+user_id).val();
            let row_id = $("#row_"+user_id).val();
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
            let id = e;
            let row_id = $("#row_"+id).val();
            let on_leave = '';
            if($("#on_leave_"+id).is(':checked') == true){
                on_leave = 1;
            } else {
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
            let id = e;
            let row_id = $("#row_"+id).val();
            let half_leave = '';
            if($("#half_leave_"+id).is(':checked') == true){
                half_leave = 1;
            } else {
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
            let id = e;
            let row_id = $("#row_"+id).val();

            let late = '';
            if($("#late_"+id).is(':checked') == true){
                late = 1;
                $("#absent_"+id).prop("checked", false);
                $("#absent_"+id).prop("disabled", true);
            } else {
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
            let id = e;
            let row_id = $("#row_"+id).val();
            let absent = '';
            if($("#absent_"+id).is(':checked') == true){
                $("#time_in_"+id).val('');
                $("#time_out_"+id).val('');

                absent = 1;
                $("#late_"+id).prop("checked", false);
                $("#late_"+id).prop("disabled", true);
            } else {
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
        function view_qa(qa_id) {
            let data = new FormData();
            data.append('qa_id', qa_id);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('qa_single_data')}}', data, 'Quality Assessment View');
        }
    </script>
@endsection