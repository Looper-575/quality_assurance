
<div class="mt-4">

<table class="table table-bordered  table-striped text-center">
    <tr>
        <th colspan="2">Total Sales</th>
        <th colspan="2">Total RGU</th>
        </tr>
    <tr>
        <td colspan="2">
            {{($total->single_play +$total->double_play + $total->triple_play + $total->quad_play) ?? 0}}
        </td>
        <td colspan="2">
            {{($total->single_play + ($total->double_play *2 ) + ($total->triple_play*3) + ($total->quad_play*4)) ?? 0}}
        </td>
    </tr>
    <tr>
        <th>Single Play</th>
        <th>Double Play</th>
        <th>Triple Play</th>
        <th>Quad Play</th>
    </tr>
    <tr>
        <td>{{$total->single_play ?? 0 }}</td>
        <td>{{$total->double_play ?? 0 }}</td>
        <td>{{$total->triple_play ?? 0}}</td>
        <td>{{$total->quad_play ?? 0  }}</td>
    </tr>
    <tr>
        <th>Internet</th>
        <th>Cable</th>
        <th>Phone</th>
        <th>Mobile</th>
    </tr>
    <tr>
        <td>{{$total->internet ?? 0}}</td>
        <td>{{$total->cable ?? 0 }}</td>
        <td>{{$total->phone ?? 0}}</td>
        <td>{{$total->mobile ?? 0}}</td>
    </tr>
</table>
</div>
<div class="table-responsive mt-4">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr>
            <th title="Field #1">S.No.</th>
            <th title="Field #2">Disposition Type</th>
            <th title="Field #3">DID Name </th>
            <th title="Field #4">Account Number</th>
            <th title="Field #4">Confirmation Number</th>
            <th title="Field #4">Order Number</th>
            <th title="Field #5">Customer Name</th>
            <th title="Field #5">Phone Number</th>
            <th title="Field #6">Service Address</th>
            <th title="Field #7">Provider Name</th>
            <th title="Field #8">Services Sold</th>
            <th title="Field #8">Services</th>
            <th title="Field #8">QA Status</th>
            <th title="Field #8">Call Recording</th>
            <th title="Field #9">Agent Name</th>
            <th title="Field #10">Added On</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($call_disp_lists as $call_disp_list)
            <tr>
                <td><a href="javascript:;" onclick="view_lead(this)" id="{{$call_disp_list->call_id}}">{{ $loop->index+1 }}</a></td>
                <td><a href="javascript:;" onclick="view_lead(this)" id="{{$call_disp_list->call_id}}">{{ $call_disp_list->call_disposition_types->title}}</a></td>
                <td>{{ isset($call_disp_list->call_disposition_did->title) ? $call_disp_list->call_disposition_did->title : ' ' }}</td>
                <td>{{ $call_disp_list->account_number }}</td>
                <td>{{ $call_disp_list->order_confirmation_number }}</td>
                <td>{{ $call_disp_list->order_number }}</td>
                <td>{{ $call_disp_list->customer_name }}</td>
                <td>{{ $call_disp_list->phone_number }}</td>
                <td>{{ $call_disp_list->service_address }}</td>
                <?php
                $providers=null;
                for($i=0; $i<count($call_disp_list->call_dispositions_services); $i++) {
                    $providers .= $call_disp_list->call_dispositions_services[$i]->provider_name.', ';
                }
                ?>
                <td>{{ $providers }}</td>
                <td>{{ $call_disp_list->services_sold }}</td>
                <td>
                    <?php

                    foreach ($call_disp_list->call_dispositions_services as $service){
                        if(isset($service->internet) && $service->internet == 1){
                            echo 'Internet,';
                        }
                        if(isset($service->cable) && $service->cable ==1){
                            echo 'cable,';
                        }
                        if(isset($service->phone) && $service->phone ==1){
                            echo 'phone,';
                        }
                        if(isset($service->mobile) && $service->mobile ==1){
                            echo 'mobile,';
                        }
                    }
                    ?>
                </td>
                @if(isset($call_disp_list->qa_status))
                    <td> <span class="badge text-white"  style="background-color:<?php echo $call_disp_list->qa_status->badge_color; ?>;">
                            {{ $call_disp_list->qa_status->monitor_percentage }} %</span>
                    </td>
                @else
                    <td>NA</td>
                @endif
                @if(isset($call_disp_list->qa_assessment))
                    <td>
                        @if($call_disp_list->qa_assessment->recording )
                            <a class="btn btn-success" href="{{route('rec_download',$call_disp_list->qa_assessment->recording)}}" data-id22="{{$call_disp_list->qa_assessment->recording}}">
                                Get Audio <i class="fa fa-download"></i>
                            </a>
                        @else
                            NA
                        @endif
                    </td>
                @else
                    <td>NA</td>
                @endif
                <td>{{ $call_disp_list->user->full_name }}</td>
                <td>{{ parse_date_time_zone($call_disp_list->added_on) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
