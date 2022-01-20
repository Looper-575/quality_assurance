<div class="table-responsive">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr id="report_header">
            <th colspan="3"><h5>{{$agent_name}}</h5></th>
            <th colspan="2"><h5>Total Working Days: {{$working_days}}</h5></th>
            <th colspan="2"><h5>Total Holidays: {{$holiday_count}}</h5></th>
        </tr>
        <tr>
            <th title="Field #1">Date</th>
            <th title="Field #2">Time In</th>
            <th title="Field #3">Time Out</th>
            <th title="Field #4">Late</th>
            <th title="Field #5">Absent</th>
            <th title="Field #6">On Leave</th>
            <th title="Field #7">Half Leave</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($attendance_list as $list)
            <tr>
                <td>{{ $list->attendance_date }}</td>
                <td>{{ $list->time_in == '' ? 'NA' : $list->time_in}}</td>
                <td>{{ $list->time_out == '' ? 'NA' : $list->time_out}}</td>
                <td>{{ $list->late == 0 ? 'No' : 'Yes'}}</td>
                <td>{{ $list->absent == 0 ? 'No' : 'Yes'}}</td>
                <td>{{ $list->on_leave == 0 ? 'No' : 'Yes'}}</td>
                <td>{{ $list->half_leave == 0 ? 'No' : 'Yes'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
