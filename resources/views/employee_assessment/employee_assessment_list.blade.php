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
                    <h3 class="m-portlet__head-text">Employee Assessments</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    @if($EmployeeAssessment_SELF)
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link {{($EmployeeAssessment_SELF ? 'active' : '')}}" data-toggle="tab" href="#self" role="tab">
                            Self Assessments
                        </a>
                    </li>
                    @endif
                    @if($EmployeeAssessment)
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link {{($EmployeeAssessment_SELF ? '' : 'active')}}" data-toggle="tab" href="#team" role="tab">
                            Team Assessments
                        </a>
                    </li>
                    @endif
                    @if(($is_admin || $is_hrm))
                        <li class="nav-item m-tabs__item">
                            <button class="nav-link m-tabs__link" onclick="initiate_employee_assessment()">
                                Initiate Employee Assessment
                            </button>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                @if($EmployeeAssessment_SELF)
                <div class="tab-pane {{($EmployeeAssessment_SELF ? 'active' : '')}}" id="self" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Employee Status</th>
                                <th>Evaluation Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($EmployeeAssessment_SELF as $employee_assessment_detail)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $employee_assessment_detail->employees->full_name }}</td>
                                    <td>{{ $employee_assessment_detail->employees->department->title}}</td>
                                    <td>{{ $employee_assessment_detail->employees->designation }}</td>
                                    <td>{{$employee_assessment_detail->employees->employment_status}}</td>
                                    <td>{{ $employee_assessment_detail->evaluation_date }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('view_employee_assessment',['id' => $employee_assessment_detail->id])}}" id="{{$employee_assessment_detail->id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                                            @if($employee_assessment_detail->employee_sign == 0 && $emp_assessment == true)
                                                <a title="fill" class="btn btn-warning text-white fill_employee_assessment hover_color" id="{{$employee_assessment_detail->id}}" href="{{route('employee_assessment_form',['id' => $employee_assessment_detail->id])}}"><i class="fa fa-edit"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @if($EmployeeAssessment)
                    <div class="tab-pane {{($EmployeeAssessment_SELF ? '' : 'active')}}" id="team" role="tabpanel">
                        <div style="width: 100%">
                            <table class="datatable table table-bordered" style="">
                                <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Employee Status</th>
                                    <th>Employee Assessment Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($EmployeeAssessment as $employee_assessment_detail)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $employee_assessment_detail->employees->full_name }}</td>
                                    <td>{{ $employee_assessment_detail->employees->department->title}}</td>
                                    <td>{{ $employee_assessment_detail->employees->designation }}</td>
                                    <td>{{$employee_assessment_detail->employees->employment_status}}</td>
                                    <td>{{ $employee_assessment_detail->evaluation_date }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('view_employee_assessment',['id' => $employee_assessment_detail->id])}}" id="{{$employee_assessment_detail->id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                                             @if(($is_admin || $employee_assessment_detail->employees->employee->manager_id == Auth::user()->user_id) && $employee_assessment_detail->employee_sign == 1 &&  $employee_assessment_detail->manager_sign == 0)
                                                <a title="fill" class="btn text-white btn-warning fill_employee_assessment hover_color" id="{{$employee_assessment_detail->id}}" href="{{route('employee_assessment_form',['id' => $employee_assessment_detail->id])}}"><i class="fa fa-edit"></i></a>
                                            @endif
                                            @if(($is_admin || $is_hrm) && $employee_assessment_detail->manager_sign == 1 && $employee_assessment_detail->hr_sign == 0)
                                                <a title="fill" class="btn btn-info fill_employee_assessment hover_color" id="{{$employee_assessment_detail->id}}" href="{{route('employee_assessment_form',['id' => $employee_assessment_detail->id])}}"><i class="fa fa-edit"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function (){
            var today = new Date().toISOString().split("T")[0];
            $('#from_date').attr('max', today);
            $('#to_date').attr('max', today);
        });
        function initiate_employee_assessment() {
            let data = new FormData();
            data.append('_token', "{{csrf_token()}}");
            call_ajax_modal('POST', '{{route('initiate_employee_assessment_form')}}', data, 'Initiate Employee Assessment');
        }
        function employee_assessment_initiate () {
            let a = function () {
                window.location.reload();
            }
            let form_data = new FormData($('#initiate_employee_assessment_form')[0]);
            form_data.append('_token', "{{csrf_token()}}");
            let arr = [a];
            call_ajax_with_functions('', '{{route('employee_assessment_initiate')}}', form_data, arr);
        }
    </script>
    <style>
        .hover_color:hover > i, .hover_color:focus > i{
            color: #ffffff !important;
        }
        .hover_color > i{
            color: white;
        }
    </style>
@endsection
