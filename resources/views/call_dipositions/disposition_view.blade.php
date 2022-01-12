<?php $status_arr = ['No', 'Yes', 'N/A']; ?>
<button class="btn btn-primary" onclick="print_div('lead_print')" style="position: absolute; top: -58px; right: 70px;">Print</button>
<div id="lead_print" style="overflow-y: scroll; height: 500px; overflow-x: hidden;">
    <h3 CLASS="text-center">Call Disposition</h3><br>
    @if($lead_data->disposition_type == 1)
        <table class="table table-bordered table-striped">
            <tr>
                <th>Disposition Type</th>
                <th>DID Name</th>
                <th>Account Number</th>
            </tr>
            <tr>
                <td>{{$lead_data->call_disposition_types->title}}</td>
                <td>{{ isset($lead_data->call_disposition_did->title) ? $lead_data->call_disposition_did->title : '' }}</td>
                <td>{{ $lead_data->account_number }}</td>

            </tr>
            <tr>
                <th>Confirmation Number</th>
                <th>Order Number</th>
                <th>Mobile Work Order Number</th>
            </tr>
            <tr>
                <td>{{ $lead_data->order_confirmation_number }}</td>
                <td>{{ $lead_data->order_number }}</td>
                <td>{{ $lead_data->mobile_work_order_number }}</td>

            </tr>
            <tr>
                <th>Phone Number</th>
                <th>Number Of Phone Lines</th>
                <th>Service Address</th>
            </tr>
            <tr>
                <td>{{ $lead_data->phone_number }}</td>
                <td>{{ $lead_data->mobile_lines }}</td>
                <td>{{ $lead_data->service_address }}</td>
            </tr>
            <tr>
                <th>Services Sold</th>
                <th>Customer Name</th>
                <th>Agent Name</th>
            </tr>
            <tr>
                <td>{{ $lead_data->services_sold }}</td>
                <td>{{ $lead_data->customer_name }}</td>
                <td>{{ $lead_data->user->full_name }}</td>
            </tr>
        </table>
        <table class="table table-bordered table-striped">
            <tr>
                <th >Providers</th>
                <th colspan="4">Services</th>
            </tr>
            <?php $providers=null; ?>
            @for($i=0; $i<count($lead_data->call_dispositions_services); $i++)
                <tr>
                    <th>{{$lead_data->call_dispositions_services[$i]->provider_name}}:</th>
                    <td>
                        <?php
                        if($lead_data->call_dispositions_services[$i]->internet == 1)
                            echo "Internet, ";
                        if($lead_data->call_dispositions_services[$i]->cable == 1)
                            echo "Cable, ";
                        if($lead_data->call_dispositions_services[$i]->phone == 1)
                            echo "Phone, ";
                        if($lead_data->call_dispositions_services[$i]->mobile == 1)
                            echo "Mobile "; ?>
                    </td>
                </tr>
            @endfor
        </table>
    @else
        <table class="table table-bordered table-striped" >

            <tr>
                <th>Disposition Type</th>
                <th>Customer Name</th>
            </tr>
            <tr>
                <td>{{$lead_data->call_disposition_types->title}}</td>
                <td>{{ $lead_data->customer_name }}</td>

            </tr>
            <tr>
                <th>Phone Number</th>
                <th>Comments</th>
            </tr>
            <tr>
                <td>{{ $lead_data->phone_number}}</td>
                <td>{{$lead_data->comments}}</td>
            </tr>
            @if(isset($transfer_from))

                <tr>
                    <th>Transferred From</th>
                </tr>
                <tr>
                    <td>{{ $transfer_from->full_name}}</td>
                </tr>
            @endif

        </table>
    @endif
    @if(isset($lead_data->qa_status))
        <br>
        <h3 CLASS="text-center">Quality Assessment Results</h3><br>
        <table style="width: 100%">
            <tr>
                <td style="width: 50%">
                    <p>Name: <STRONG>{{ $lead_data->qa_status->agent->full_name }}</STRONG><br>
                        Call Type: <Strong>{{ $lead_data->qa_status->call_type->title }}</Strong><br>
                        Percentage: <strong>{{ $lead_data->qa_status->monitor_percentage }}%</strong></p>
                </td>
                <td>
                    <p>Call Date: <strong>{{ $lead_data->qa_status->call_date }}</strong><br>
                        Call Number: <strong>{{ $lead_data->qa_status->call_number }}</strong><br>
                        QA Status: <strong class="badge text-white" style="background-color:<?php echo $lead_data->qa_status->badge_color; ?>;">{{ $lead_data->qa_status->badge_title }}</strong><br>
                    </p>
                </td>
            </tr>
        </table>
        <table class="table table-bordered table-striped" id="chkbox_table">
            <tr>
                <th>Greetings</th>
                <th>Customer Name</th>
            </tr>
            <tr>
                <td>
                    Correct Greetings: <strong>{{$status_arr[$lead_data->qa_status->greetings_correct]}}</strong><br>
                    Assurity Staement: <strong>{{ $status_arr[$lead_data->qa_status->greetings_assurity_statement]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->greetings_comment}}

                </td>
                <td>
                    Customer's Name: <strong>{{$status_arr[$lead_data->qa_status->customer_name_call]}}</strong><br>
                    <Strong>Comments</Strong><br>
                    {{$lead_data->qa_status->customer_comment}}
                </td>
            </tr>
            <tr>
                <th>Listening</th>
                <th>Equipment Use</th>
            </tr>
            <tr>
                <td>
                    listening Skills: <strong>{{$status_arr[$lead_data->qa_status->listening_skills]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->listening_comment}}
                </td>
                <td>
                    Prompt System: <strong>{{$status_arr[$lead_data->qa_status->equipment_system]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->equipment_comment}}
                </td>
            </tr>
            <tr>
                <th>Courtesy</th>
                <th>Using Hold</th>
            </tr>
            <tr>
                <td>
                    Courtesy Please: <strong>{{$status_arr[$lead_data->qa_status->courtesy_please]}}</strong><br>
                    Courtesy Thank You: <strong>{{$status_arr[$lead_data->qa_status->courtesy_thank_you]}}</strong><br>
                    Courtesy Interest: <strong>{{$status_arr[$lead_data->qa_status->courtesy_interest]}}</strong><br>
                    Courtesy Empathy: <strong>{{$status_arr[$lead_data->qa_status->courtesy_empathy]}}</strong><br>
                    Courtesy Apologized: <strong>{{$status_arr[$lead_data->qa_status->courtesy_Apologized]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->courtesy_comment}}
                </td>
                <td>
                    Informed the Customer: <strong>{{$status_arr[$lead_data->qa_status->using_hold_informed_customer]}}</strong><br>
                    Kept in Touch: <strong>{{$status_arr[$lead_data->qa_status->using_hold_touch]}}</strong><br>
                    Thanked the Customer: <strong>{{$status_arr[$lead_data->qa_status->using_hold_thanked]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->using_hold_comment}}
                </td>
            </tr>
            <tr>
                <th>Closing</th>
                <th>Connecting Calls </th>
            </tr>
            <tr>
                <td>
                    Quick Recap: <strong>{{$status_arr[$lead_data->qa_status->closing_recap]}}</strong><br>
                    Used Proper Closing: <strong>{{$status_arr[$lead_data->qa_status->clossing_assistance]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->closing_comment}}
                </td>
                <td>
                    Connected to Department: <strong>{{$status_arr[$lead_data->qa_status->connecting_calls_department]}}</strong><br>
                    Informed customer: <strong>{{$status_arr[$lead_data->qa_status->connecting_calls_customer]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->connecting_calls_comment}}
                </td>
            </tr>
            <tr>
                <th>Soft Skills</th>
                <th>Automatic Fail</th>
            </tr>
            <tr>
                <td>
                    Voice Reflected: <strong>{{$status_arr[$lead_data->qa_status->soft_skills_energy]}}</strong><br>
                    Avoided Long Silence: <strong>{{$status_arr[$lead_data->qa_status->soft_skill_avoided_silence]}}</strong><br>
                    Used Polite: <strong>{{$status_arr[$lead_data->qa_status->soft_skill_polite]}}</strong><br>
                    Used Grammar: <strong>{{$status_arr[$lead_data->qa_status->soft_skill_grammar]}}</strong><br>
                    Refrained: <strong>{{$status_arr[$lead_data->qa_status->soft_skill_refrained_company]}}</strong><br>
                    Used Positive Words: <strong>{{$status_arr[$lead_data->qa_status->soft_skill_positive_words]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->soft_skills_comment}}

                </td>
                <td>
                    Misquoting the Price: <strong>{{$status_arr[$lead_data->qa_status->automatic_fail_misquoting]}}</strong><br>
                    Disconnected Call: <strong>{{$status_arr[$lead_data->qa_status->automatic_fail_disconnected ]}}</strong><br>
                    Failure to Answer: <strong>{{$status_arr[$lead_data->qa_status->automatic_fail_answer]}}</strong><br>
                    Repeating Confidential: <strong>{{$status_arr[$lead_data->qa_status->automatic_fail_repeating_details]}}</strong><br>
                    Changing Customer Details: <strong>{{$status_arr[$lead_data->qa_status->automatic_fail_changing_details]}}</strong><br>
                    Fabricating Information: <strong>{{$status_arr[$lead_data->qa_status->automatic_fail_fabricating]}}</strong><br>
                    Other: <strong>{{$status_arr[$lead_data->qa_status->automatic_fail_other]}}</strong><br>
                    <strong>Comments</strong><br>
                    {{$lead_data->qa_status->automatic_fail_comment}}
                </td>
            </tr>
            <th>Additional Comments</th>
            <tr>
                <td colspan="2">{{$lead_data->qa_status->additional_comment}}
                </td>
            </tr>
        </table>
    @endif
</div>
