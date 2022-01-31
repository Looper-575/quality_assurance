@extends('layout.template')
@section('header_scripts')
   <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}"
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Sales Transfer List</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#home" role="tab">
                            Unpproved
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#profile" role="tab">
                            Approved
                        </a>
                    </li>
                    @if($has_permissions->add == 1)
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" href="{{route('sales_transfer_form')}}" >
                            Sales Transfer Form
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered">
                            <thead>
                            <tr>
                                <th>Account# / Confirmation# / Order#</th>
                                <th>Customer Name</th>
                                <th>Phone  Number</th>
                                <th>Service Address</th>
                                <th>Transfer From</th>
                                <th>Transfer To</th>
                                <th>Added On</th>
                                <th>Supervisor Approval</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transfer_lists_unapproved as $transfer_list)
                                <tr>
                                    <td>{{ $transfer_list->call_disposition->account_number  }} / {{$transfer_list->call_disposition->order_confirmation_number}} / {{ $transfer_list->call_disposition->order_number}}</td>
                                    <td>{{ $transfer_list->call_disposition->customer_name }}</td>
                                    <td>{{ $transfer_list->call_disposition->phone_number }}</td>
                                    <td>{{ $transfer_list->call_disposition->service_address }}</td>
                                    <td>{{$transfer_list->user->full_name}}</td>
                                    <td>{{ $transfer_list->transferTo->full_name }}</td>
                                    <td>{{ parse_datetime_store($transfer_list->added_on) }}</td>
                                    @if($transfer_list->approved_my_supervisor == 0 || $transfer_list->approved_transfer_supervisor == 0 || $transfer_list->admin_approved == 0)
                                        <td>Pending</td>
                                    @endif
                                    @if(isset($transfer_list->user->team_member->team))

                                        @if(($transfer_list->user->team_member->team->team_lead_id == Auth::user()->user_id && $transfer_list->approved_my_supervisor == 0) || ($transfer_list->transfer_manager_id == Auth::user()->user_id && $transfer_list->approved_transfer_supervisor == 0 ))

                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button title="Reject" class="btn btn-danger p-3" onclick="reject_transfer(this);" value="{{$transfer_list->transfer_id}}" ><i class="fa fa-times"></i></button>
                                                <button title="Approve" class="btn btn-success p-3" onclick="approve_transfer(this);" value="{{$transfer_list->transfer_id}}" ><i class="fa fa-check"></i></button>
                                            </div>
                                        </td>
                                     @else
                                        <td></td>
                                    @endif
                                    @else
                                        @if(Auth::user()->role_id == 1 && $transfer_list->admin_approved == 0 )
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button title="Reject" class="btn btn-danger p-3" onclick="reject_transfer(this);" value="{{$transfer_list->transfer_id}}" ><i class="fa fa-times"></i></button>
                                                <button title="Approve" class="btn btn-success p-3" onclick="approve_transfer(this);" value="{{$transfer_list->transfer_id}}" ><i class="fa fa-check"></i></button>
                                            </div>
                                        </td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered">
                            <thead>
                            <tr>
                                <th>Account# / Confirmation# / Order#</th>
                                <th>Customer Name</th>
                                <th>Phone  Number</th>
                                <th>Service Address</th>
                                <th>Transferred From</th>
                                <th>Transferred To</th>
                                <th>Added On</th>
                                <th>Same Team Transfer</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($transfer_lists as $transfer_list)
                                <tr>
                                    <td>{{ $transfer_list->call_disposition->account_number  }} / {{$transfer_list->call_disposition->order_confirmation_number}} / {{ $transfer_list->call_disposition->order_number}}</td>
                                    <td>{{ $transfer_list->call_disposition->customer_name }}</td>
                                    <td>{{ $transfer_list->call_disposition->phone_number }}</td>
                                    <td>{{ $transfer_list->call_disposition->service_address }}</td>
                                    <td>{{$transfer_list->user->full_name}}</td>
                                    <td>{{ $transfer_list->transferTo->full_name }}</td>
                                    <td>{{ parse_datetime_store($transfer_list->added_on) }}</td>
                                    <td> {{$transfer_list->is_team_transfer == 1 ? 'Yes':'No'}}</td>
                                </tr>
                            @endforeach
                            </tbody>
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

    function reject_transfer (me) {
        let id = me.value;
        let data = new FormData();
        data.append('id', id);
        data.append('_token', "{{csrf_token()}}");
        swal({
            title: "Are you sure?",
            text: "Do you really want to reject this application",
            icon: "warning",
            buttons: [
                'No',
                'Yes, Reject Application!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {

                let a = function () {
                    window.location.href = "{{route('sales_transfer_list')}}";
                };
                let arr = [a];
                call_ajax_with_functions('', '{{route('sales_transfer_reject')}}', data, arr);
            }
        });
    }

    function approve_transfer (me) {
        let id = me.value;
        let data = new FormData();
        data.append('id', id);
        data.append('_token', "{{csrf_token()}}");
        swal({
            title: "Are you sure?",
            text: "Do you really want to Accept this application",
            buttons: [
                'No',
                'Yes, Accept Application!'
            ],
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {
                let a = function () {
                    window.location.reload();
                };
                let arr = [a];
                call_ajax_with_functions('', '{{route('sales_transfer_approve')}}', data, arr);
            }
        });
    }



</script>
@endsection
