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
                    <h3 class="m-portlet__head-text">Employee Assessments List</h3>
                </div>
                @if($is_admin == false && $self_assessment == true)
                    <div class="float-right mt-3">
                        <a href="{{route('employee_assessment_form')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-phone-square"></i><span>Fill Self Assesment Form</span></span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                @endif
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    @if($EmployeeAssessment_SELF)
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link {{($EmployeeAssessment_SELF ? 'active' : '')}}" data-toggle="tab" href="#self" role="tab">
                            SELF ASSESSMENTS
                        </a>
                    </li>
                    @endif
                    @if($EmployeeAssessment)
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link {{($EmployeeAssessment_SELF ? '' : 'active')}}" data-toggle="tab" href="#team" role="tab">
                            TEAM ASSESSMENTS
                        </a>
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
                                <th title="Field #1">S.No</th>
                                <th title="Field #2">Employee Name</th>
                                <th title="Field #4">Department</th>
                                <th title="Field #4">Designation</th>
                                <th title="Field #5">Employee Status</th>
                                <th title="Field #6">Evaluation Date</th>
                                <th title="Field #8">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($EmployeeAssessment_SELF as $employee_assessment_detail)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $employee_assessment_detail->employees->full_name }}</td>
                                    <td>{{ $employee_assessment_detail->employees->department->title}}</td>
                                    <td>{{ $employee_assessment_detail->employees->designation }}</td>
                                    <td>{{ $employee_assessment_detail->confirmation_status }}</td>
                                    <td>{{ $employee_assessment_detail->evaluation_date }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('view_employee_assessment',['id' => $employee_assessment_detail->id])}}" id="{{$employee_assessment_detail->id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
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
                                    <th title="Field #1">S.No</th>
                                    <th title="Field #2">Employee Name</th>
                                    <th title="Field #4">Department</th>
                                    <th title="Field #4">Designation</th>
                                    <th title="Field #5">Employee Status</th>
                                    <th title="Field #6">Employee Assessment Date</th>
                                    <th title="Field #8">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($EmployeeAssessment as $employee_assessment_detail)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $employee_assessment_detail->employees->full_name }}</td>
                                        <td>{{ $employee_assessment_detail->employees->department->title}}</td>
                                        <td>{{ $employee_assessment_detail->employees->designation }}</td>
                                        <td>{{ $employee_assessment_detail->confirmation_status }}</td>
                                        <td>{{ $employee_assessment_detail->evaluation_date }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{route('view_employee_assessment',['id' => $employee_assessment_detail->id])}}" id="{{$employee_assessment_detail->id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
            {{--                                @if($is_employee && $employee_assessment_detail->manager_sign == 0)--}}
            {{--                                    <a title="fill" class="btn btn-primary fill_employee_assessment" id="{{$employee_assessment_detail->id}}" href="{{route('employee_assessment_form',['id' => $employee_assessment_detail->id])}}"><i class="fa fa-edit"></i></a>--}}
            {{--                                @endif--}}
                                                @if(($is_admin || $is_manager) && $employee_assessment_detail->manager_sign == 0)
                                                    <a title="fill" class="btn btn-primary fill_employee_assessment" id="{{$employee_assessment_detail->id}}" href="{{route('employee_assessment_form',['id' => $employee_assessment_detail->id])}}"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if(($is_admin || $is_hrm) && $employee_assessment_detail->manager_sign == 1 && $employee_assessment_detail->hr_sign == 0)
                                                    <a title="fill" class="btn btn-info fill_employee_assessment" id="{{$employee_assessment_detail->id}}" href="{{route('employee_assessment_form',['id' => $employee_assessment_detail->id])}}"><i class="fa fa-edit"></i></a>
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
@endsection