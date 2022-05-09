<div class="table-responsive">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr id="report_header">
            <th colspan="3"><h5>Employee Name: {{$employee_name}}</h5></th>
            <th colspan="2"><h5>Report:
                    <?php
                            $start_month = strtotime($start_month);
                            $curr_month  = strtotime($curr_month);
                            echo date('M-Y', $start_month).'-'.date('M-Y', $curr_month);
                    ?>
                </h5></th>
            <th colspan="4"><h5>Total Working Days: {{$working_days}}</h5><h5>Total Holidays: {{$holiday_count}}</h5></th>
        </tr>
        <tr>
            <th title="Field #1" colspan="2">Month</th>
            <th title="Field #2">Annual Leaves</th>
            <th title="Field #3">Casual Leaves</th>
            <th title="Field #4">Sick Leaves</th>
            <th title="Field #5">Upaid Leaves</th>
            <th title="Field #6">Half Day Leaves</th>
            <th title="Field #7">Total Leaves</th>
        </tr>
        </thead>
        <tbody>
        <?php $total_leaves = $annual_leaves = $causal_leaves = $sick_leaves = $half_leaves = $upaid_leaves = 0?>
        @foreach ($leaves_taken as $leaves)
            @if($leaves->leave_type_id == 1)
                <?php
                    $annual_leaves = $leaves->leaves_taken;
                ?>
            @elseif($leaves->leave_type_id == 2)
                <?php
                $causal_leaves = $leaves->leaves_taken;
                ?>
            @elseif($leaves->leave_type_id == 3)
                <?php
                $sick_leaves = $leaves->leaves_taken;
                ?>
            @elseif($leaves->leave_type_id == 4)
                <?php
                $half_leaves = $leaves->leaves_taken;
                ?>
            @else
                <?php
                $upaid_leaves = $leaves->leaves_taken;
                ?>
            @endif
            <?php $total_leaves = $annual_leaves + $causal_leaves + $sick_leaves + $half_leaves + $upaid_leaves;?>
            <tr>
                <td colspan="2"><?php echo date("F", mktime(null, null, null, $leaves->month, 1));?></td>
                <td>{{ $annual_leaves }}</td>
                <td>{{ $causal_leaves}}</td>
                <td>{{ $sick_leaves}}</td>
                <td>{{ $upaid_leaves }}</td>
                <td>{{ $half_leaves }}</td>
                <td>{{ $total_leaves }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
