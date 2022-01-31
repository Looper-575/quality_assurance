<div style="width: 100%">
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
                        /><label class="form-check-label pr-4 mt-1" for="half_leave_{{@$agent_list->user->user_id}}"> Half Leave</label>

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
</div>
