<style>
    #generated_lead_list td,#generated_lead_list th{
        height: 40px;
    }
    #generated_lead_list th{
        font-weight: bold;
    }
</style>

<div class="mt-4">
@if(isset($total))
<table id="generated_lead_list" class="table table-bordered  table-striped text-center">
    <tr>
        <th>Total RGU</th>
        <th>Single Play</th>
        <th>Double Play</th>
        <th>Triple Play</th>
        <th>Quad Play</th>
    </tr>
    <tr>
        <td>{{($total->single_play + ($total->double_play *2 ) + ($total->triple_play*3) + ($total->quad_play*4)) ?? 0}}</td>
        <td>{{$total->single_play ?? 0 }}</td>
        <td>{{$total->double_play ?? 0 }}</td>
        <td>{{$total->triple_play ?? 0}}</td>
        <td>{{$total->quad_play ?? 0  }}</td>
    </tr>
    <tr>
        <th >Total Sales</th>
        <th>Internet</th>
        <th>Cable</th>
        <th>Phone</th>
        <th>Mobile</th>
    </tr>
    <tr>
        <td>{{($total->single_play +$total->double_play + $total->triple_play + $total->quad_play) ?? 0}}</td>
        <td>{{$total->internet ?? 0}}</td>
        <td>{{$total->cable ?? 0 }}</td>
        <td>{{$total->phone ?? 0}}</td>
        <td>{{$total->mobile ?? 0}}</td>
    </tr>
</table>
    @endif
</div>
<div class="table-responsive mt-4">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr>
            <th>S.No.</th>
            <th>Disposition Type</th>
            <th>DID Name </th>
            <th>Account Number</th>
            <th>Confirmation Number</th>
            <th>Order Number</th>
            <th>Customer Name</th>
            <th>Phone Number</th>
            <th>Service Address</th>
            <th>Provider Name</th>
            <th>Services Sold</th>
            <th>Services</th>
            <th>QA Status</th>
            <th>Call Recording</th>
            <th>Agent Name</th>
            <th>Added On</th>
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
