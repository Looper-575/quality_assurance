@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Leave Bucket Lists</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#unapproved" role="tab">
                            Unapproved
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#approved" role="tab">
                            Approved
                        </a>
                    </li>
                    @if($is_admin == TRUE)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" href="{{route('leaves_bucket_form')}}">
                                Add New
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">

            <div class="tab-content">
                <div class="tab-pane active" id="unapproved" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Name</th>
                                <th>Start Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($unapproved_leaves_bucket)
                                @foreach ($unapproved_leaves_bucket as $index => $bucket)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $bucket->user->full_name }}</td>
                                        <td>{{ $bucket->start_date }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button onclick="approve_application(this);" value="{{$bucket->bucket_id}}" class="btn btn-success"><i class="text-white fa fa-check"></i></button>
                                                <button onclick="reject_application(this);" value="{{$bucket->bucket_id}}" class="btn btn-danger"><i class="text-white fa fa-times"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>No Record Found</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="approved" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Name</th>
                                <th>Start Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($approved_leaves_bucket)
                                @foreach ($approved_leaves_bucket as $index => $bucket)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $bucket->user->full_name }}</td>
                                        <td>{{ $bucket->start_date }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{route('view_leaves_bucket',['bucket_id' => $bucket->bucket_id, 'user_id' => $bucket->user_id])}}" id="{{$bucket->bucket_id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                                                @if($is_admin || $is_hr)
                                                    <a title="Edit" class="btn btn-warning edit_leaves_bucket" id="{{$bucket->bucket_id}}" href="{{route('leaves_bucket_form',['bucket_id' => $bucket->bucket_id])}}"><i class="fa fa-edit text-white"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>No Record Found</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="add_new" role="tabpanel">
                    <div style="width: 100%">

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
        function reject_application (me) {
            let id = me.value;
            let data = new FormData();
            data.append('id', id);
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
                    call_ajax('', '{{route('leave_bucket_reject')}}', data);
                }
            })
        }
        function approve_application (me) {
            let id = me.value;
            let data = new FormData();
            data.append('id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to Approve this Leave Bucket",
                buttons: [
                    'No',
                    'Yes, Accept Leave Bucket!'
                ],
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    let a = function () {
                        window.location.href = "{{route('leaves_bucket')}}";
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('leave_bucket_approve')}}', data, arr);
                }
            });
        }
    </script>
@endsection
