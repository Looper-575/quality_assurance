<div class="container-fluid" style="margin-top: -10px;overflow-y: auto;overflow-x: hidden;height: 300px;">
    <div>
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
                $check_leave_bucket = get_leave_bucket_leaves($user_id);
                ?>
                <td id="remaining_annual">{{$check_leave_bucket['remaining_annual']}}</td>
                <td id="remaining_casual">{{$check_leave_bucket['remaining_casual']}}</td>
                <td id="remaining_sick">{{$check_leave_bucket['remaining_sick']}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <table class="table tab-bordered table-striped">
        <tr>
            <th>Date</th>
            <th>Leave</th>
            <th>Half Leave</th>
            <th>Late</th>
            <th>Absent</th>
        </tr>
        @foreach($report as $rep)
        <tr>
            <td>{{$rep->attendance_date}}</td>
            <td>{{$rep->applied_leave}}</td>
            <td>{{$rep->half_leave}}</td>
            <td>{{$rep->late}}</td>
            <td>{{$rep->absent}}</td>
        </tr>
        @endforeach
    </table>
</div>
