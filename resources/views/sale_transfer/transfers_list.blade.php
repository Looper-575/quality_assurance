@extends('layout.template')
@section('header_scripts')
   <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}"
@endsection
@section('content')
    <h4>Sales Transfer List</h4>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Unapproved</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Approved</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-block" style="width: 100% !important;">
                        <h4 class="float-left">Unapproved Sales Transfer List</h4>
                    </div>
                    <div class="card-body">
                        <div class="m-portlet__body">
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

                                        @if($transfer_list->approved_my_supervisor == 0 || $transfer_list->approved_transfer_supervisor == 0)

                                        <td>Pending</td>
                                        @endif
                                        @if(($transfer_list->user->manager_id == Auth::user()->user_id && $transfer_list->approved_my_supervisor == 0) ||($transfer_list->transfer_manager_id == Auth::user()->user_id && $transfer_list->approved_transfer_supervisor == 0 ))

                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button title="Reject" class="btn btn-danger p-3" onclick="reject_transfer(this);" value="{{$transfer_list->transfer_id}}" ><i class="fa fa-times"></i></button>
                                                <button title="Approve" class="btn btn-success p-3" onclick="approve_transfer(this);" value="{{$transfer_list->transfer_id}}" ><i class="fa fa-check"></i></button>
                                            </div>
                                        </td>

                                        @else
                                            <td></td>
                                        @endif

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-block" style="width: 100% !important;">
                        <h4 class="float-left">Approved Sales Transfer List</h4>
                    </div>
                    <div class="card-body">
                        <div class="m-portlet__body">
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
                                    <th>Team Transfer</th>
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
