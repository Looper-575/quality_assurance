<div class="table-responsive">
    <table class="table table-striped" id="reports_table">
        <thead>
        <tr>
            <th>S.No.</th>
            <th>Disposition Type</th>
            <th>DID Name </th>
            <th>Acc# / Conf# / Order#</th>
            <th>Customer Name / Phone#</th>
            <th>Service Address</th>
            <th>Provider Name</th>
            <th>Services Sold</th>
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
                <td>{{ $call_disp_list->account_number }}<br>{{ $call_disp_list->order_confirmation_number }}<br>{{ $call_disp_list->order_number }}</td>
                <td>{{ $call_disp_list->customer_name }}<br>{{ $call_disp_list->phone_number }}</td>
                <td>{{ $call_disp_list->service_address }}</td>
                <?php
                $providers=null;
                for($i=0; $i<count($call_disp_list->call_dispositions_services); $i++) {
                    $providers .= $call_disp_list->call_dispositions_services[$i]->provider_name.', ';
                }
                ?>
                <td>{{ $providers }}</td>
                <td>{{ $call_disp_list->services_sold }}</td>
                <td>{{ $call_disp_list->user->full_name }}</td>
                <td>{{ parse_datetime_store($call_disp_list->added_on) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
