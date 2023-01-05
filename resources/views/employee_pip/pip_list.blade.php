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
                    <h3 class="m-portlet__head-text">Performance Improvement Plans List</h3>
                </div>
                @if($is_employee == false)
                    <div class="float-right mt-3">
                        <a href="{{route('pip_form')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-phone-square"></i><span>Add New PIP</span></span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Employee Name</th>
                    <th>Manager Name</th>
                    <th>PIP Duration</th>
                    <th>Review Dates</th>
                    <th>Target Date</th>
                    <th>Employee Acknowledgement</th>
                    <th>Manager/HR Approval</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pip as $pip_detail)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $pip_detail->employee->full_name }}</td>
                        <td>{{ $pip_detail->manager->full_name }}</td>
                        <td>{{ $pip_detail->pip_from}} - {{ $pip_detail->pip_to}}</td>
                        <td>{{ $pip_detail->review_date }}</td>
                        <td>{{ $pip_detail->target_date }}</td>
                        <td class="text-white">
                            @if($pip_detail->employee_acknowledgement == 1)
                                <span class="badge bg-info">Acknowledged</span>
                            @else
                                <span class="badge bg-danger"> Pending</span>
                            @endif
                        </td>
                        <td class="text-white">
                            @if($pip_detail->manager_approve == 1)
                                <span class="badge bg-warning mb-1">Manager Approved</span>
                            @else
                                <span class="badge bg-danger mb-1"> Manager Approval Pending</span>
                            @endif
                            @if($pip_detail->hr_approve == 1)
                                <span class="badge bg-success">HR Approved</span>
                            @else
                                <span class="badge bg-danger">HR Approval Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{route('view_pip',['pip_id' => $pip_detail->pip_id])}}" id="{{$pip_detail->pip_id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                            @if($is_employee)
                                @if($pip_detail->employee_acknowledgement == 0)
                                     <button class="btn btn-info text-white" onclick="employee_ack_pip_with_comments(this);" value="{{$pip_detail->pip_id}}">Employee Ack</button>
                                @endif
                            @else
                                @if( ($is_manager || $is_hr) && ($pip_detail->employee_acknowledgement == 0) )
                                      <a title="Edit" class="btn btn-primary edit_pip" id="{{$pip_detail->pip_id}}" href="{{route('pip_form',['pip_id' => $pip_detail->pip_id])}}"><i class="fa fa-edit"></i></a>
                                @endif
                                @if($is_hr && $pip_detail->hr_approve == 0 && $pip_detail->employee_acknowledgement == 1)
                                      <button class="btn btn-warning text-white" onclick="hr_approve_pip(this);" value="{{$pip_detail->pip_id}}">HR Approve</button>
                                @endif
                            @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        function employee_ack_pip_with_comments (me) {
            let pip_id = me.value;
            let data = new FormData();
            data.append('pip_id', pip_id);
            data.append('_token', "{{csrf_token()}}");
            call_ajax_modal('POST', '{{route('employee_ack_pip_with_comments')}}', data, 'Employee Comments on PIP');
        }
        function employee_ack_pip () {
            let a = function () {
                location.reload();
            }
            let form_data = new FormData($('#employee_comments_pip')[0]);
            form_data.append('_token', "{{csrf_token()}}");
            let arr = [a];
            call_ajax_with_functions('', '{{route('employee_ack_pip')}}', form_data, arr);
        }
        function hr_approve_pip (me){
            let id = me.value;
            let data = new FormData();
            data.append('pip_id', id);
            data.append('_token', "{{csrf_token()}}");
            let a = function () {
                location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('hr_approve_pip')}}', data, arr);
        }

    </script>
@endsection
