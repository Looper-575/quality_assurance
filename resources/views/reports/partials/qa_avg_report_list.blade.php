<div class="table-responsive mt-5">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr>
            <th>S.No.</th>
            <th>Agent Name</th>
            <th>No of Calls</th>
            <th>No of Fatal Calls</th>
            <th>Monitor Percentage</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($qa_lists as $qa_list)
            <tr>
                <td>{{ $loop->index+1 }}</a></td>
                <td>{{ $qa_list->agent->full_name }}</td>
                <td>{{ $qa_list->sales_count }}</td>
                <td>{{ $qa_list->fatal }}</td>
                <td>
                    @foreach($qa_bage as $bagde)
                        @if($qa_list->monitor_percentage >= $bagde->min && $qa_list->monitor_percentage <= $bagde->max)
                            <span class="badge text-white" title="{{$bagde->title}}" style="background-color:<?php echo $bagde->color; ?>;">{{ round($qa_list->monitor_percentage, 1) }}</span>
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
