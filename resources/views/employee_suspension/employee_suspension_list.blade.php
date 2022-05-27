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
                    <h3 class="m-portlet__head-text">Employee Separations List</h3>
                </div>
                @if($is_admin == TRUE)
                    <div class="float-right mt-3">
                        <a  href="{{route('suspension_form')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            Add Employee Suspension
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                @endif
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#current" role="tab">
                                Current Suspended
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#archived" role="tab">
                                Archived
                            </a>
                        </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="current" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Employee Name</th>
                    <th>Effective From</th>
                    <th>Effective Till</th>
                    <th>Suspension Reason</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($employee_suspension as $suspension)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td><a href="{{route('employee_data_view',['employee_id' => $suspension->user->employee->employee_id])}}">{{ $suspension->user->full_name }}</a></td>
                        <td>{{ $suspension->from_date }}</td>
                        <td>{{ $suspension->to_date }}</td>
                        <td>{{ $suspension->reason }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($is_admin)
                                    <a href="{{route('suspension_view',['suspension_id' => $suspension->suspension_id])}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                                    <a href="{{route('suspension_form',['suspension_id' => $suspension->suspension_id])}}" class="btn btn-primary" ><i class="fa fa-edit"></i></a>
                                    <button title="unsuspend_user_account" class="btn btn-warning" onclick="unsuspend_user_account(this);" value="{{$suspension->user_id}}"><i class="fa fa-user-times"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                    </div>
                </div>
                <div class="tab-pane" id="archived" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Employee Name</th>
                    <th>Effective From</th>
                    <th>Effective Till</th>
                    <th>Suspension Reason</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($archived_employee_suspension as $archived_suspension)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $archived_suspension->user->full_name }}</td>
                        <td>{{ $archived_suspension->from_date }}</td>
                        <td>{{ $archived_suspension->to_date }}</td>
                        <td>{{ $archived_suspension->reason }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($is_admin)
                                    <a href="{{route('suspension_view',['suspension_id' => $archived_suspension->suspension_id])}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                                @endif
                            </div>
                        </td>
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
        function unsuspend_user_account (me) {
            let suspended_user_id = me.value;
            let data = new FormData();
            data.append('suspended_user_id', suspended_user_id);
            data.append('_token', "{{csrf_token()}}");
            call_ajax('', '{{route('unsuspend_user_account')}}', data);
        }
    </script>
@endsection
