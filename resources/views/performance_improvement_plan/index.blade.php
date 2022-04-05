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
                @if($is_staff == false)
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
                    <th title="Field #1">S.No</th>
                    <th title="Field #2">CSR Name</th>
                    <th title="Field #3">OM Name</th>
                    <th title="Field #4">PIP Duration</th>
                    <th title="Field #5">Review Dates</th>
                    <th title="Field #6">Target Date</th>
                    <th title="Field #7">Staff Acknowledgement</th>
                    <th title="Field #7">OM/HRM Approval</th>
                    <th title="Field #8">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pip as $pip_detail)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $pip_detail->staff->full_name }}</td>
                        <td>{{ $pip_detail->operation_manager->full_name }}</td>
                        <td>{{ $pip_detail->pip_from}} - {{ $pip_detail->pip_to}}</td>
                        <td>{{ $pip_detail->review_date }}</td>
                        <td>{{ $pip_detail->target_date }}</td>
                        <td class="text-white">
                            @if($pip_detail->staff_acknowledgement == 1)
                                <span class="badge bg-info">Acknowledged</span>
                            @else
                                <span class="badge bg-danger"> Pending</span>
                            @endif
                        </td>
                        <td class="text-white">
                            @if($pip_detail->om_approve == 1)
                                <span class="badge bg-warning mb-1">OM Approved</span>
                            @else
                                <span class="badge bg-danger mb-1"> OM Approval Pending</span>
                            @endif
                            @if($pip_detail->hrm_approve == 1)
                                <span class="badge bg-success">HRM Approved</span>
                            @else
                                <span class="badge bg-danger">HRM Approval Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{route('view_pip',['pip_id' => $pip_detail->pip_id])}}" id="{{$pip_detail->pip_id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                            @if($is_staff)
                                @if($pip_detail->staff_acknowledgement == 0)
                                     <button class="btn btn-info text-white" onclick="staff_ack_pip_with_comments(this);" value="{{$pip_detail->pip_id}}">Staff Ack</button>
                                @endif
                            @else
                                @if( ($is_om || $is_hrm) && ($pip_detail->staff_acknowledgement == 0) )
                                      <a title="Edit" class="btn btn-primary edit_pip" id="{{$pip_detail->pip_id}}" href="{{route('pip_form',['pip_id' => $pip_detail->pip_id])}}"><i class="fa fa-edit"></i></a>
                                @endif
                                @if($is_hrm && $pip_detail->hrm_approve == 0 && $pip_detail->staff_acknowledgement == 1)
                                      <button class="btn btn-warning text-white" onclick="hrm_approve_pip(this);" value="{{$pip_detail->pip_id}}">HRM Approve</button>
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
        function staff_ack_pip_with_comments (me) {
            let pip_id = me.value;
            let data = new FormData();
            data.append('pip_id', pip_id);
            data.append('_token', "{{csrf_token()}}");
            call_ajax_modal('POST', '{{route('staff_ack_pip_with_comments')}}', data, 'Staff Comments on PIP');
        }
        function staff_ack_pip () {
            let a = function () {
                location.reload();
            }
            let form_data = new FormData($('#staff_comments_pip')[0]);
            form_data.append('_token', "{{csrf_token()}}");
            let arr = [a];
            call_ajax_with_functions('', '{{route('staff_ack_pip')}}', form_data, arr);
        }
        function hrm_approve_pip (me){
            let id = me.value;
            let data = new FormData();
            data.append('pip_id', id);
            data.append('_token', "{{csrf_token()}}");
            let a = function () {
                location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('hrm_approve_pip')}}', data, arr);
        }

    </script>
@endsection
