<div class="table-responsive">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr>
            <th title="Field #1">S.No.</th>
            <th>Agent Name</th>
            <th title="Field #2">Disposition Type</th>
            <th title="Field #3">Call Number </th>
            <th>Call Date</th>
            @if($call_type == 1 )
                <th>Order Number</th>
                <th>Order Confirmation Number</th>
                <th>Account Number</th>
            @endif
            <th title="Field #4">Monitor Percentage</th>
            <th title="Field #5">Call Recordings</th>
            <th title="Field #6">Added On</th>
            <th title="Field #7">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($qa_lists as $qa_list)
            <tr>
                <td>{{ $loop->index+1 }}</a></td>
                <td>{{ $qa_list->agent->full_name }}</td>
                <td>{{ $qa_list->call_type->title }}</td>
                <td>{{ $qa_list->call_number }}</td>
                <td>{{ parse_date_store($qa_list->call_date) }}</td>
                @if($qa_list->call_type->call_type_id == 1 )
                    <td>{{$qa_list->call_disposition->order_number}}</td>
                    <td>{{$qa_list->call_disposition->order_confirmation_number}}</td>
                    <td>{{$qa_list->call_disposition->account_number}}</td>
                @endif
            @if(isset($qa_list->qa_status))
                    <td> <span class="badge text-white"  style="background-color:<?php echo $qa_list->qa_status->badge_color; ?>;">{{ $qa_list->qa_status->monitor_percentage }}    %</span></td>
                @else
                    <td>NA</td>
                @endif
                <td>
                    @if($qa_list->recording )
                        <a class="btn btn-success" href="{{route('rec_download',$qa_list->recording)}}" data-id22="{{$qa_list->recording}}">
                            Get Audio <i class="fa fa-download"></i>
                        </a>
                    @else
                        NA
                    @endif
                </td>
                <td>{{ parse_date_time_zone($qa_list->added_on) }}</td>
                <td>
                <div class="btn-group btn-group-sm">
                    <button title="View" class="btn btn-primary p-3"   onclick="view_qa(this)" id="{{$qa_list->qa_id}}"><i class="fa fa-eye"></i></button>
                </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
