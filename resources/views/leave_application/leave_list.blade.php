@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-block" style="width: 100% !important;">
                    <h4 class="float-left">Leave Applications List</h4>
                    <a class="btn btn-icon icon-left btn-primary float-right" href="{{ route('leave_form') }}">
                        <i class="fas fa-plus"></i> Add new</a>
{{--                    <form action="{{route('buy_flow_delete')}}" method="post">--}}
{{--                        @csrf--}}
{{--                        <button type="submit" class="btn btn-danger float-right ml-2">Delete</button>--}}
{{--                    </form>--}}
{{--                    <form action="{{route('buy_flow_approved')}}" method="post">--}}
{{--                        @csrf--}}
{{--                        <button type="submit" class="btn btn-primary float-right">Approved</button>--}}
{{--                    </form>--}}
                </div>
                <div class="card-body">
                    <div >
                        <table class="table table-striped table-responsive" id="chkbox_table">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Half Type</th>
                                <th>No of Leaves</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leave_lists as $leave_list)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$leave_list->leaveType->title}}</td>
                                    <td>{{$leave_list->from }}</td>
                                    <td>{{$leave_list->to}}</td>
                                    <td>{{$leave_list->half_type }}</td>
                                    <td>{{$leave_list->no_leaves}}</td>
                                    <td>{{$leave_list->reason }}</td>
                                    <td>{{$leave_list->status}}</td>
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
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    {{--    <script>--}}
    {{--$( document ).ready(function() {--}}
    {{--    // Approve action--}}
    {{--    $('.approve_action').click(function (){--}}
    {{--        let data = new FormData();--}}
    {{--        data.append('_token', "{{ csrf_token() }}");--}}
    {{--        data.append('_method', "PUT");--}}
    {{--        let a = function(){ window.location.href = '{{ route('imports.index') }}'; };--}}
    {{--        let arr = [a];--}}
    {{--        call_ajax_with_functions('','{{ route('imports.index') }}'+'/approve/'+this.value,data,arr);--}}
    {{--    });--}}
    {{--    //Reject Action--}}
    {{--    $('.reject_action').click(function (e) {--}}
    {{--        let data = new FormData();--}}
    {{--        data.append('_token', "{{ csrf_token() }}");--}}
    {{--        data.append('_method', "delete");--}}
    {{--        let a = function(){ window.location.href = '{{ route('imports.index') }}'; };--}}
    {{--        let arr = [a];--}}
    {{--        call_ajax_with_functions('','{{ route('imports.index') }}'+'/'+this.value,data,arr);--}}
    {{--    });--}}
    {{--    //Reject Action--}}
    {{--    $('.view_action').click(function (e) {--}}
    {{--        call_ajax_modal('GET', '{{ route('imports.index') }}'+'/'+this.value, '', 'Product Details');--}}
    {{--    });--}}
    {{--});--}}
    {{--    </script>--}}
@endsection
