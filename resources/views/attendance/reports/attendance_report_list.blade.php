<div class="table-responsive">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr>
            <th colspan="2"><h5>Report: <?php $yrdata= strtotime($month); echo date('M-Y', $yrdata); ?></h5></th>
            <th colspan="3"><h5>Total Working Days: {{$working_days}}</h5></th>
            <th colspan="2"><h5>Total Holidays: {{$holiday_count}}</h5></th>
        </tr>
        <tr>
            <th title="Field #1">Agent Name</th>
            <th title="Field #2">Attendance Marked</th>
            <th title="Field #3">Present</th>
            <th title="Field #4">On Leave</th>
            <th title="Field #5">Half Day Leave</th>
            <th title="Field #6">Lates</th>
            <th title="Field #7">Absents</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($attendance_list as $call_disp_list)
            <tr>
                <td>{{ $call_disp_list->user->full_name }}</td>
                <td>{{ $call_disp_list->attendance_marked }}</td>
                <td>{{ $call_disp_list->attendance_marked - ($call_disp_list->absents + $call_disp_list->leaves)}}</td>
                <td>{{ $call_disp_list->leaves }}</td>
                <td>{{ $call_disp_list->half_leaves }}</td>
                <td>{{ $call_disp_list->lates }}</td>
                <td>{{ $call_disp_list->absents }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
