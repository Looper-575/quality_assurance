@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php
    $role = Auth::user()->role->title;
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Call Disposition List</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#sale_made_list" role="tab">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            Sale
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#non_sale_list" role="tab">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            Non Sale
                        </a>
                    </li>
                    @if($has_permissions->add == 1)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" href="{{route('lead_form')}}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add New
                            </a>
                        </li>
                    @endif
                </ul>

            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="sale_made_list" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" id="sale_made_table" style="width:100%">
                            <thead>
                            <tr>
                                <th>DID Name </th>
                                <th>Account Number</th>
                                <th>Confirmation Number</th>
                                <th>Order  Number</th>
                                <th>Mobile Work Order Number</th>
                                <th>Customer Name</th>
                                <th>Phone  Number</th>
                                <th>Service Address</th>
                                <th>Provider Name</th>
                                <th>Services Sold</th>
                                <th>Services</th>
                                <th>Agent Name</th>
                                <th>Transefer Status</th>
                                <th>QA Status</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sale_made as $call_disp_list)
                                <tr>
                                    <td>{{ isset($call_disp_list->call_disposition_did->title) ? $call_disp_list->call_disposition_did->title : ' ' }}</td>
                                    <td>{{ $call_disp_list->account_number }}</td>
                                    <td>{{ $call_disp_list->order_confirmation_number }}</td>
                                    <td>{{ $call_disp_list->order_number }}</td>
                                    <td>{{ $call_disp_list->mobile_work_order_number }}</td>
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
                                    <td>{{ @$call_disp_list->user->full_name }}</td>
                                    <td>{{$call_disp_list->sale_transferred==1?'Yes':'No'}}</td>
                                    @if(isset($call_disp_list->qa_status))
                                        <td> <span class="badge text-white"  style="background-color:<?php echo $call_disp_list->qa_status->badge_color; ?>;">{{ $call_disp_list->qa_status->monitor_percentage }} %</span></td>
                                    @else
                                        <td>NA</td>
                                    @endif
                                    <td>{{ parse_datetime_store($call_disp_list->added_on) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($has_permissions->view == 1)
                                            <a onclick="view_lead(this)" id="{{$call_disp_list->call_id}}" class="btn btn-primary" href="javascript:;" data-toggle="m-tooltip" data-placement="right" data-skin="dark" data-container="body">
                                                <i class="la la-eye"></i>
                                            </a>
                                            @endif
                                            @if($has_permissions->update == 1)
                                                <a class="btn btn-info"  href="{{route('lead_edit' , $call_disp_list->call_id)}}">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endif
                                            @if($role === 'Admin')
                                                <a href="javascript:;" onclick="delete_lead(this);" id="{{$call_disp_list->call_id}}" class="btn btn-danger" href="#" data-toggle="m-tooltip" data-placement="left">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>DID Name </th>
                                <th>Account Number</th>
                                <th>Confirmation Number</th>
                                <th>Order  Number</th>
                                <th>Mobile Work Order Number</th>
                                <th>Customer Name</th>
                                <th>Phone  Number</th>
                                <th>Service Address</th>
                                <th>Provider Name</th>
                                <th>Services Sold</th>
                                <th>Services</th>
                                <th>Agent Name</th>
                                <th>QA Status</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="non_sale_list" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" id="non_sale_table" style="width:100%">
                            <thead>
                            <tr>
                                <th>Disposition Type</th>
                                <th>Did</th>
                                <th>Customer Name</th>
                                <th>Phone  Number</th>
                                <th>Agent Name</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($call_disp_lists as $call_disp_list)
                                <tr>
                                    <td>{{ $call_disp_list->call_disposition_types->title}}</td>
                                    <td>{{ isset($call_disp_list->call_disposition_did->title) ? $call_disp_list->call_disposition_did->title : ' ' }}</td>
                                    <td>{{ $call_disp_list->customer_name }}</td>
                                    <td>{{ $call_disp_list->phone_number }}</td>
                                    <td>{{ @$call_disp_list->user->full_name }}</td>
                                    <td>{{ parse_datetime_store($call_disp_list->added_on) }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if($has_permissions->view == 1)
                                            <a onclick="view_lead(this)" id="{{$call_disp_list->call_id}}" class="btn btn-primary" href="javascript:;" data-toggle="m-tooltip" data-placement="right" data-skin="dark" data-container="body">
                                                <i class="la la-eye"></i>
                                            </a>
                                            @endif
                                            @if($has_permissions->update == 1)
                                                <a class="btn btn-info"  href="{{route('lead_edit' , $call_disp_list->call_id)}}">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endif
                                            @if($role === 'Admin')
                                                <a href="javascript:;" onclick="delete_lead(this);" id="{{$call_disp_list->call_id}}" class="btn btn-danger" href="#" data-toggle="m-tooltip" data-placement="left">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Disposition Type</th>
                                <th>Did</th>
                                <th>Customer Name</th>
                                <th>Phone  Number</th>
                                <th>Agent Name</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>

        function delete_lead (me) {
            let id = me.id;
            let data = new FormData();
            data.append('call_id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to delete this record? You will not be able to recover this.",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $(me).closest('tr').fadeOut('slow', function (){
                        $(this).remove();
                    });
                    call_ajax('', '{{route('lead_delete')}}', data);
                }
            })
        }
        function view_lead(me) {
            let data = new FormData();
            data.append('call_id', me.id);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('lead_single_data')}}', data, 'Call Disposition View');
        }
    </script>
@endsection
