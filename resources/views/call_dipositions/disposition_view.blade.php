
<button class="btn btn-primary" onclick="print_div('lead_print')" style="position: absolute; top: -50px; right: 60px;">Print</button>
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
                <th>Customer Name</th>
            </tr>
            <tr>
                <td>{{ $lead_data->order_confirmation_number }}</td>
                <td>{{ $lead_data->order_number }}</td>
                <td>{{ $lead_data->customer_name }}</td>

            </tr>
            <tr>
                <th>Phone Number</th>
                <th>Service Address</th>
                <th>Services Sold</th>
            </tr>
            <tr>
                <td>{{ $lead_data->phone_number }}</td>
                <td>{{ $lead_data->service_address }}</td>
                <td>{{ $lead_data->services_sold }}</td>
            </tr>
            <tr>
                <th>Agent Name</th>
            </tr>
            <tr>
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

        </table>
    @endif
</div>
