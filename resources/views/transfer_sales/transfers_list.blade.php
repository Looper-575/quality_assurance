@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    {{--    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">--}}
@endsection
@section('content')
    <h4>Sale Transfers List</h4>


    <div class="row"  id="profile">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-block" style="width: 100% !important;">
                        <h4 class="float-left">Transfer List</h4>
                    </div>
                    <div class="card-body">
                        <div class="m-portlet__body">
                            <table class="datatable table table-bordered" id="chkbox_table">
                                <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Leave Type</th>
                                    <th>Name</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Half Type</th>
                                    <th>No of Leaves</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Manager Approval</th>
                                    <th>HR Approval</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transfer_lists as $leave_list)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$leave_list->leaveType->title}}</td>
                                        <td>{{ $leave_list->user->full_name}}</td>
                                        <td>{{$leave_list->from }}</td>
                                        <td>{{$leave_list->to}}</td>
                                        <td>{{$leave_list->half_type }}</td>
                                        <td>{{$leave_list->no_leaves}}</td>
                                        <td>{{$leave_list->reason }}</td>
                                        <td>{{$leave_list->status}}</td>
                                        <td>Approved</td>
                                        <td>Approved</td>
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
@endsection
