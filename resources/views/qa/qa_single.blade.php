<?php $status_arr = ['No', 'Yes', 'N/A']; ?>
<button class="btn btn-primary" onclick="print_div('qa_print')" style="position: absolute; top: -50px; right: 60px;">Print</button>
<div id="qa_print" style="overflow-y: scroll; height: 500px; overflow-x: hidden;">
   <h1 style="text-align: center">Quality Assessment Results</h1>
    <table style="width: 100%">
       <tr>
           <td style="width: 50%">
               <p>Name: <STRONG>{{ $qa_data->agent->full_name }}</STRONG><br>
                   Call Type: <Strong>{{ $qa_data->call_type->title }}</Strong><br>
                   Percentage:<strong>{{ $qa_data->monitor_percentage }}</strong></p>
           </td>
           <td>
               <p>Call Date: <strong>{{ $qa_data->call_date }}</strong><br>
                   Call Number: <strong>{{ $qa_data->call_number }}</strong><br>
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
                Correct Greetings: <strong>{{$status_arr[$qa_data->greetings_correct]}}</strong><br>
                Assurity Staement: <strong>{{ $status_arr[$qa_data->greetings_assurity_statement]}}</strong><br>
                <strong>Comments</strong><br>
                {{$qa_data->greetings_comment}}

            </td>
            <td>
                Customer's Name: <strong>{{$status_arr[$qa_data->customer_name_call]}}</strong><br>
                <Strong>Comments</Strong><br>
                {{$qa_data->customer_comment}}
            </td>
        </tr>
        <tr>
            <th>Listening</th>
            <th>Equipment Use</th>
        </tr>
        <tr>
        <td>
            listening Skills: <strong>{{$status_arr[$qa_data->listening_skills]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->listening_comment}}
        </td>
        <td>
            Prompt System: <strong>{{$status_arr[$qa_data->equipment_system]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->equipment_comment}}
        </td>
        </tr>
        <tr>
            <th>Courtesy</th>
            <th>Using Hold</th>
        </tr>
        <tr>
        <td>
            Courtesy Please: <strong>{{$status_arr[$qa_data->courtesy_please]}}</strong><br>
            Courtesy Thank You: <strong>{{$status_arr[$qa_data->courtesy_thank_you]}}</strong><br>
            Courtesy Interest: <strong>{{$status_arr[$qa_data->courtesy_interest]}}</strong><br>
            Courtesy Empathy: <strong>{{$status_arr[$qa_data->courtesy_empathy]}}</strong><br>
            Courtesy Apologized: <strong>{{$status_arr[$qa_data->courtesy_Apologized]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->courtesy_comment}}
        </td>
        <td>
            Informed the Customer: <strong>{{$status_arr[$qa_data->using_hold_informed_customer]}}</strong><br>
            Kept in Touch: <strong>{{$status_arr[$qa_data->using_hold_touch]}}</strong><br>
            Thanked the Customer: <strong>{{$status_arr[$qa_data->using_hold_thanked]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->using_hold_comment}}
        </td>
        </tr>
        <tr>
            <th>Closing</th>
            <th>Connecting Calls </th>
        </tr>
        <tr>
        <td>
            Quick Recap: <strong>{{$status_arr[$qa_data->closing_recap]}}</strong><br>
            Used Proper Closing: <strong>{{$status_arr[$qa_data->clossing_assistance]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->closing_comment}}
        </td>
        <td>
            Connected to Department: <strong>{{$status_arr[$qa_data->connecting_calls_department]}}</strong><br>
            Informed customer: <strong>{{$status_arr[$qa_data->connecting_calls_customer]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->connecting_calls_comment}}
        </td>
        </tr>
        <tr>
            <th>Soft Skills</th>
            <th>Automatic Fail</th>
        </tr>
        <tr>
        <td>
            Voice Reflected: <strong>{{$status_arr[$qa_data->soft_skills_energy]}}</strong><br>
            Avoided Long Silence: <strong>{{$status_arr[$qa_data->soft_skill_avoided_silence]}}</strong><br>
            Used Polite: <strong>{{$status_arr[$qa_data->soft_skill_polite]}}</strong><br>
            Used Grammar: <strong>{{$status_arr[$qa_data->soft_skill_grammar]}}</strong><br>
            Refrained: <strong>{{$status_arr[$qa_data->soft_skill_refrained_company]}}</strong><br>
            Used Positive Words: <strong>{{$status_arr[$qa_data->soft_skill_positive_words]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->soft_skills_comment}}

        </td>
        <td>
            Misquoting the Price: <strong>{{$status_arr[$qa_data->automatic_fail_misquoting]}}</strong><br>
            Disconnected Call: <strong>{{$status_arr[$qa_data->automatic_fail_disconnected ]}}</strong><br>
            Failure to Answer: <strong>{{$status_arr[$qa_data->automatic_fail_answer]}}</strong><br>
            Repeating Confidential: <strong>{{$status_arr[$qa_data->automatic_fail_repeating_details]}}</strong><br>
            Changing Customer Details: <strong>{{$status_arr[$qa_data->automatic_fail_changing_details]}}</strong><br>
            Fabricating Information: <strong>{{$status_arr[$qa_data->automatic_fail_fabricating]}}</strong><br>
            Other: <strong>{{$status_arr[$qa_data->automatic_fail_other]}}</strong><br>
            <strong>Comments</strong><br>
            {{$qa_data->automatic_fail_comment}}
        </td>
        </tr>
        <th>Additional Comments</th>
        <tr>
            <td colspan="2">{{$qa_data->additional_comment}}
            </td>
        </tr>
    </table>
</div>

