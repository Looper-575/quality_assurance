<div class="table-responsive">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr>
            <th title="Field #1">Agent Name</th>
            <th title="Field #1">Total Working Days</th>
            <th title="Field #2">Present</th>
            <th title="Field #3">On Leave</th>
            <th title="Field #3">Half Day Leave</th>
            <th title="Field #4">Lates</th>
            <th title="Field #5">Absents</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($attendance_list as $call_disp_list)
            <tr>
                <td>{{ $call_disp_list->user->full_name }}</td>
                <td>{{ $call_disp_list->working_days }}</td>
                <td>{{ $call_disp_list->working_days - ($call_disp_list->absents + $call_disp_list->leaves)}}</td>
                <td>{{ $call_disp_list->leaves }}</td>
                <td>{{ $call_disp_list->half_leaves }}</td>
                <td>{{ $call_disp_list->lates }}</td>
                <td>{{ $call_disp_list->absents }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
