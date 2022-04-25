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
                    <h3 class="m-portlet__head-text">Leave Applications Lists</h3>
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
                            <a class="nav-link m-tabs__link" href="{{route('leave_form')}}">
                                Leave Form
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->user_team && $has_permissions->add == 1)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" href="{{route('team_leave_form')}}">
                                Team Leave Form
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
                                <th>Manager Approval</th>
                                <th>HR Approval</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($leave_lists_unapproved as $leave_list)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$leave_list->leaveType->title}}</td>
                                    <td>{{ $leave_list->user->full_name}}</td>
                                    <td>{{$leave_list->from }}</td>
                                    <td>{{$leave_list->to}}</td>
                                    <td>{{$leave_list->half_type }}</td>
                                    <td>{{$leave_list->no_leaves}}</td>
                                    <td>{{$leave_list->reason }}</td>
                                    <td>{{$leave_list->approved_by_manager == NULL ? 'Pending' :( $leave_list->approved_by_manager == 1 ? 'Approved' : 'Not Approved')}}</td>
                                    <td>{{$leave_list->approved_by_hr == NULL ? 'Pending' :( $leave_list->approved_by_hr == 1 ? 'Approved' : 'Not Approved')}}</td>

                                    @if(Auth::user()->role_id == $manager_id && $leave_list->approved_by_manager == NULL && $leave_list->added_by != Auth::user()->user_id )
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button title="Reject" class="btn btn-danger p-3"  onclick="reject_application(this);" value="{{$leave_list->leave_id}}"><i class="fa fa-times"></i></button>
                                                <button title="Approve" class="btn btn-success p-3" onclick="approve_application(this);" value="{{$leave_list->leave_id}}"><i class="fa fa-check"></i></button>
                                            </div>
                                        </td>
                                    @elseif(Auth::user()->role_id == 5)
                                        @if($leave_list->approved_by_hr == NULL && $leave_list->approved_by_manager != NULL)
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button title="Reject" class="btn btn-danger p-3" onclick="reject_application(this);" value="{{$leave_list->leave_id}}"><i class="fa fa-times"></i></button>
                                                    <button title="Approve" class="btn btn-success p-3" onclick="approve_application(this);" value="{{$leave_list->leave_id}}"><i class="fa fa-check"></i></button>
                                                </div>
                                            </td>
                                        @endif
                                    @endif

                                    @if(Auth::user()->user_id == $leave_list->added_by && ($leave_list->approved_by_manager == NULL && $leave_list->approved_by_hr == NULL))
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                @if($has_permissions->update == 1)
                                                    <a href="{{route('leave_form_edit',$leave_list->leave_id)}}" title="Edit"  class="edit_application btn btn-primary p-3" ><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if(Auth::user()->role_id != 1)
                                                    <button title="Delete" class="btn btn-danger p-3" onclick="delete_leave(this);" value="{{$leave_list->leave_id}}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                    @if(Auth::user()->role_id == 1)
                                        <td>
                                            <button title="Delete" class="btn btn-danger p-3" onclick="delete_leave(this);" value="{{$leave_list->leave_id}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                    <div style="width: 100%">
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
                            @foreach($leave_lists as $leave_list)
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
<script>
    function reject_application (me) {
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
                    window.location.href = "{{route('leave_list')}}";
                };
                let arr = [a];
                call_ajax_with_functions('', '{{route('leave_reject')}}', data, arr);
            }
        });
    }
    function approve_application (me) {
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
                    window.location.href = "{{route('leave_list')}}";
                };
                let arr = [a];
                call_ajax_with_functions('', '{{route('leave_approve')}}', data, arr);
            }
        });
    }
    function delete_leave (me) {
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
                call_ajax('', '{{route('leave_delete')}}', data);
            }
        })
    }
    function change_password(me) {
        $('#change_pass_modal').fadeIn();
        $('#c_user_id').val(me.value);
    }
</script>
