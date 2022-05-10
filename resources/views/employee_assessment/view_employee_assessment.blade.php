@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title float-left">
                                <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                                <h3 class="m-portlet__head-text">Employee Assessment Details</h3>
                            </div>
                            <div class="float-right mt-3">
                                <a href="{{route('employee_assessment')}}"  class="btn btn-primary">
                                    Back
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <div class="row">
                            <div class="col-lg-2">
                                <b>Employee Name:</b>
                            </div>
                            <div class="col-lg-2">
                                <span>{{ $EmployeeAssessment->employees->full_name }}</span>
                            </div>
                            <div class="col-lg-2">
                                <b>Designation:</b>
                            </div>
                            <div class="col-lg-2">
                                <span>{{ $EmployeeAssessment->employees->designation }}</span>
                            </div>
                            <div class="col-lg-2">
                                <b>Department:</b>
                            </div>
                            <div class="col-lg-2">
                                <span>{{ $EmployeeAssessment->employees->department->title }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <b>Date of Joining:</b>
                            </div>
                            <div class="col-lg-2">
                                <span>{{ $EmployeeAssessment->employees->joining_date }}</span>
                            </div>
                            <div class="col-lg-2">
                                <b>Assessment Period:</b>
                            </div>
                            <div class="col-lg-2">
                                <span>{{ $EmployeeAssessment->period }}</span>
                            </div>
                            <div class="col-lg-2">
                                <b>Total Service:</b>
                            </div>
                            <div class="col-lg-2">
                                <span>{{ $EmployeeAssessment->total_service }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <b>Total Presents (last 3 months) : </b>
                                <span>{{ (empty($EmployeeAssessment->attendance) ? $attendance_log['presents'] : $EmployeeAssessment->attendance)}} %</span>
                            </div>
                            <div class="col-4">
                                <b>Tardiness (last 3 months): </b>
                                <span>{{ (empty($EmployeeAssessment->tardiness) ? $attendance_log['late'] : $EmployeeAssessment->tardiness)}} %</span>
                            </div>
                            @if($EmployeeAssessment->probation_extension == 'YES')
                            <div class="col-4">
                                <b>Probation Extended Till: </b>
                                <span>{{$EmployeeAssessment->probation_extension_to_date}}</span>
                            </div>
                            @endif
                        </div>
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Employee Self Assessment</h4>
                                @if($EmployeeAssessment->employee_sign == 1)
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><b>Employee's understanding of main duties, responsibilities.:</b></p>
                                            <p>{{ $EmployeeAssessment->esa_duties }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><b>Employee's most important achievement during the review period:</b></p>
                                            <p>{{ $EmployeeAssessment->esa_achievements }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><b>Employee's aims and tasks for future:</b></p>
                                            <p>{{ $EmployeeAssessment->esa_future_aims }}</p>
                                        </div>
                                    </div>
                                    @if($employee_self_evaluation)
                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                        <h4>Evaluation By Employee</h4>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="discipline">Discipline</label></td>
                                                            <td><label for="discipline">{{ $employee_self_evaluation ?  $employee_self_evaluation->discipline :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="punctuality">Punctuality</label></td>
                                                            <td><label for="punctuality">{{ $employee_self_evaluation ?  $employee_self_evaluation->punctuality :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="performance">Performance</label></td>
                                                            <td><label for="performance">{{ $employee_self_evaluation ?  $employee_self_evaluation->performance :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="efficiency">Efficiency</label></td>
                                                            <td><label for="efficiency">{{ $employee_self_evaluation ?  $employee_self_evaluation->efficiency :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="dependability">Dependability</label></td>
                                                            <td><label for="dependability">{{ $employee_self_evaluation ?  $employee_self_evaluation->dependability :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="adaptability">Adaptability</label></td>
                                                            <td><label for="adaptability">{{ $employee_self_evaluation ?  $employee_self_evaluation->adaptability :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="problem_solving">Problem Solving</label></td>
                                                            <td><label for="problem_solving">{{ $employee_self_evaluation ?  $employee_self_evaluation->problem_solving :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="peer_behaviour">Behavior with Peers</label></td>
                                                            <td><label for="peer_behaviour">{{ $employee_self_evaluation ?  $employee_self_evaluation->peer_behaviour :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="work_dedication">Dedication to Work</label></td>
                                                            <td><label for="work_dedication">{{ $employee_self_evaluation ?  $employee_self_evaluation->work_dedication :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="customer_handling">Customer Handling</label></td>
                                                            <td><label for="customer_handling">{{ $employee_self_evaluation ?  $employee_self_evaluation->customer_handling :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="customer_service">Customer Service</label></td>
                                                            <td><label for="customer_service">{{ $employee_self_evaluation ?  $employee_self_evaluation->customer_service :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="communication">Communication</label></td>
                                                            <td><label for="communication">{{ $employee_self_evaluation ?  $employee_self_evaluation->communication :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="job_knowledge">Job Knowledge</label></td>
                                                            <td><label for="job_knowledge">{{ $employee_self_evaluation ?  $employee_self_evaluation->job_knowledge :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="attitude">Attitude</label></td>
                                                            <td><label for="attitude">{{ $employee_self_evaluation ?  $employee_self_evaluation->attitude :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="team_work">Team Work</label></td>
                                                            <td><label for="team_work">{{ $employee_self_evaluation ?  $employee_self_evaluation->team_work :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="decision_making">Decision Making</label></td>
                                                            <td><label for="decision_making">{{ $employee_self_evaluation ?  $employee_self_evaluation->decision_making :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="independence">Independence</label></td>
                                                            <td><label for="independence">{{ $employee_self_evaluation ?  $employee_self_evaluation->independence :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="initiative">Initiative</label></td>
                                                            <td><label for="initiative">{{ $employee_self_evaluation ?  $employee_self_evaluation->initiative :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="supervision">Supervision</label></td>
                                                            <td><label for="supervision">{{ $employee_self_evaluation ?  $employee_self_evaluation->supervision :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="leadership">Leadership</label></td>
                                                            <td><label for="leadership">{{ $employee_self_evaluation ?  $employee_self_evaluation->leadership :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="WOW">WOW</label></td>
                                                            <td><label for="WOW">{{ $employee_self_evaluation ?  $employee_self_evaluation->WOW :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="technical_application">Technical Application</label></td>
                                                            <td><label for="technical_application">{{ $employee_self_evaluation ?  $employee_self_evaluation->technical_application :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="quality_of_work">Quality of Work</label></td>
                                                            <td><label for="quality_of_work">{{ $employee_self_evaluation ?  $employee_self_evaluation->quality_of_work :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="quantity_of_work">Quantity of Work</label></td>
                                                            <td><label for="quantity_of_work">{{ $employee_self_evaluation ?  $employee_self_evaluation->quantity_of_work :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="organization_planning">Organization and Planning</label></td>
                                                            <td><label for="organization_planning">{{ $employee_self_evaluation ?  $employee_self_evaluation->organization_planning :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="productivity">Productivity</label></td>
                                                            <td><label for="productivity">{{ $employee_self_evaluation ?  $employee_self_evaluation->productivity :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="reliability">Reliability</label></td>
                                                            <td><label for="reliability">{{ $employee_self_evaluation ?  $employee_self_evaluation->reliability :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="coaching">Coaching</label></td>
                                                            <td><label for="coaching">{{ $employee_self_evaluation ?  $employee_self_evaluation->coaching :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @if($EmployeeAssessment->manager_sign == 1)
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Assessment by Manager {{$manager_name}}</h4>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><b>Please state his/her understanding of main duties and responsibilities:</b></p>
                                            <p>{{ $EmployeeAssessment->manager_comments }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p><b>Please state his/her Training and Development needs in understanding of future roles:</b></p>
                                            <p>{{ $EmployeeAssessment->manager_additional_comments }}</p>
                                        </div>
                                    </div>
                                    @if($employee_objectives && count($employee_objectives)>0)
                                    <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Goals and Objectives</h4>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="text-align: center;">
                                                    <thead>
                                                    <tr>
                                                        <th rowspan="4">
                                                            <div class="form-group m-form__group">
                                                                <label for="objective">Description of Objectives</label>
                                                            </div>
                                                        </th>
                                                        <th rowspan="4">
                                                            <div class="form-group m-form__group">
                                                                <label for="measurement_index">How will the Objectives be Measured</label>
                                                            </div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="form-group m-form__group">
                                                                <label for="remarks">Achievement Remarks</label>
                                                            </div>
                                                        </th>
                                                        <th rowspan="2">
                                                            <div class="form-group m-form__group">
                                                                <label for="timeline">Timeline</label>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($employee_objectives as $objective)
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group m-form__group">
                                                                        <label for="previous_objective">{{$objective ? $objective->objective : ''}}</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group m-form__group">
                                                                        <label for="previous_measurement_index">{{$objective ? $objective->measurement_index : ''}}</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group m-form__group">
                                                                        <label for="previous_remarks">{{$objective ? $objective->remarks : ''}}</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group m-form__group">
                                                                        <label for="previous_timeline">{{$objective ? $objective->timeline : ''}}</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($employee_manager_evaluation)
                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                    <h4>Evaluation By Manager</h4>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="discipline">Discipline</label></td>
                                                            <td><label for="discipline">{{ $employee_manager_evaluation ? $employee_manager_evaluation->discipline : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="punctuality">Punctuality</label></td>
                                                            <td><label for="punctuality">{{ $employee_manager_evaluation ? $employee_manager_evaluation->punctuality : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="performance">Performance</label></td>
                                                            <td><label for="performance">{{ $employee_manager_evaluation ? $employee_manager_evaluation->performance : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="efficiency">Efficiency</label></td>
                                                            <td><label for="efficiency">{{ $employee_manager_evaluation ? $employee_manager_evaluation->efficiency : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="dependability">Dependability</label></td>
                                                            <td><label for="dependability">{{ $employee_manager_evaluation ? $employee_manager_evaluation->dependability : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="adaptability">Adaptability</label></td>
                                                            <td><label for="adaptability">{{ $employee_manager_evaluation ? $employee_manager_evaluation->adaptability : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="problem_solving">Problem Solving</label></td>
                                                            <td><label for="problem_solving">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->problem_solving :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="peer_behaviour">Behavior with Peers</label></td>
                                                            <td><label for="peer_behaviour">{{ $employee_manager_evaluation ? $employee_manager_evaluation->peer_behaviour : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="work_dedication">Dedication to Work</label></td>
                                                            <td><label for="work_dedication">{{ $employee_manager_evaluation ? $employee_manager_evaluation->work_dedication : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="customer_handling">Customer Handling</label></td>
                                                            <td><label for="customer_handling">{{ $employee_manager_evaluation ? $employee_manager_evaluation->customer_handling : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="customer_service">Customer Service</label></td>
                                                            <td><label for="customer_service">{{ $employee_manager_evaluation ? $employee_manager_evaluation->customer_service : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="communication">Communication</label></td>
                                                            <td><label for="communication">{{ $employee_manager_evaluation ? $employee_manager_evaluation->communication : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="job_knowledge">Job Knowledge</label></td>
                                                            <td><label for="job_knowledge">{{ $employee_manager_evaluation ? $employee_manager_evaluation->job_knowledge : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="attitude">Attitude</label></td>
                                                            <td><label for="attitude">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->attitude :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="team_work">Team Work</label></td>
                                                            <td><label for="team_work">{{ $employee_manager_evaluation ? $employee_manager_evaluation->team_work : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="decision_making">Decision Making</label></td>
                                                            <td><label for="decision_making">{{ $employee_manager_evaluation ? $employee_manager_evaluation->decision_making : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="independence">Independence</label></td>
                                                            <td><label for="independence">{{ $employee_manager_evaluation ? $employee_manager_evaluation->independence : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="initiative">Initiative</label></td>
                                                            <td><label for="initiative">{{ $employee_manager_evaluation ? $employee_manager_evaluation->initiative : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="supervision">Supervision</label></td>
                                                            <td><label for="supervision">{{ $employee_manager_evaluation ? $employee_manager_evaluation->supervision : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="leadership">Leadership</label></td>
                                                            <td><label for="leadership">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->leadership :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="WOW">WOW</label></td>
                                                            <td><label for="WOW">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->WOW :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="technical_application">Technical Application</label></td>
                                                            <td><label for="technical_application">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->technical_application :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="quality_of_work">Quality of Work</label></td>
                                                            <td><label for="quality_of_work">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->quality_of_work :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="quantity_of_work">Quantity of Work</label></td>
                                                            <td><label for="quantity_of_work">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->quantity_of_work :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="organization_planning">Organization and Planning</label></td>
                                                            <td><label for="organization_planning">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->organization_planning :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="productivity">Productivity</label></td>
                                                            <td><label for="productivity">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->productivity :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="reliability">Reliability</label></td>
                                                            <td><label for="reliability">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->reliability :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="coaching">Coaching</label></td>
                                                            <td><label for="coaching">{{ $employee_manager_evaluation ?  $employee_manager_evaluation->coaching :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>
                        @endif
                        @if($EmployeeAssessment->hr_sign == 1)
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Assessment by HR Manager {{$hr_name}}</h4>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <b>Attendance:</b>
                                        </div>
                                        <div class="col-lg-3">
                                            <span>{{ $EmployeeAssessment->attendance }}</span>
                                        </div>
                                        <div class="col-lg-3">
                                            <b>Tardiness:</b>
                                        </div>
                                        <div class="col-lg-3">
                                            <span>{{ $EmployeeAssessment->tardiness }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <b>Written Warning:</b>
                                        </div>
                                        <div class="col-lg-3">
                                            <span>{{ $EmployeeAssessment->written_warning }}</span>
                                        </div>
                                        <div class="col-lg-3">
                                            <b>Verbal Warning:</b>
                                        </div>
                                        <div class="col-lg-3">
                                            <span>{{ $EmployeeAssessment->verbal_warning }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <b>HR's Additional Comments (*if any):</b>
                                        </div>
                                        <div class="col-lg-6">
                                            <span>{{ $EmployeeAssessment->hr_comments }}</span>
                                        </div>
                                    </div>
                                    @if($employee_hr_evaluation)
                                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                        <h4>Evaluation By HR Manager</h4>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="discipline">Discipline</label></td>
                                                            <td><label for="discipline">{{ $employee_hr_evaluation ? $employee_hr_evaluation->discipline : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="punctuality">Punctuality</label></td>
                                                            <td><label for="punctuality">{{ $employee_hr_evaluation ? $employee_hr_evaluation->punctuality : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="performance">Performance</label></td>
                                                            <td><label for="performance">{{ $employee_hr_evaluation ? $employee_hr_evaluation->performance : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="efficiency">Efficiency</label></td>
                                                            <td><label for="efficiency">{{ $employee_hr_evaluation ? $employee_hr_evaluation->efficiency : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="dependability">Dependability</label></td>
                                                            <td><label for="dependability">{{ $employee_hr_evaluation ? $employee_hr_evaluation->dependability : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="adaptability">Adaptability</label></td>
                                                            <td><label for="adaptability">{{ $employee_hr_evaluation ? $employee_hr_evaluation->adaptability : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="problem_solving">Problem Solving</label></td>
                                                            <td><label for="problem_solving">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->problem_solving :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="peer_behaviour">Behavior with Peers</label></td>
                                                            <td><label for="peer_behaviour">{{ $employee_hr_evaluation ? $employee_hr_evaluation->peer_behaviour : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="work_dedication">Dedication to Work</label></td>
                                                            <td><label for="work_dedication">{{ $employee_hr_evaluation ? $employee_hr_evaluation->work_dedication : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="customer_handling">Customer Handling</label></td>
                                                            <td><label for="customer_handling">{{ $employee_hr_evaluation ? $employee_hr_evaluation->customer_handling : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="customer_service">Customer Service</label></td>
                                                            <td><label for="customer_service">{{ $employee_hr_evaluation ? $employee_hr_evaluation->customer_service : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="communication">Communication</label></td>
                                                            <td><label for="communication">{{ $employee_hr_evaluation ? $employee_hr_evaluation->communication : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="job_knowledge">Job Knowledge</label></td>
                                                            <td><label for="job_knowledge">{{ $employee_hr_evaluation ? $employee_hr_evaluation->job_knowledge : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="attitude">Attitude</label></td>
                                                            <td><label for="attitude">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->attitude :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="team_work">Team Work</label></td>
                                                            <td><label for="team_work">{{ $employee_hr_evaluation ? $employee_hr_evaluation->team_work : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="decision_making">Decision Making</label></td>
                                                            <td><label for="decision_making">{{ $employee_hr_evaluation ? $employee_hr_evaluation->decision_making : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="independence">Independence</label></td>
                                                            <td><label for="independence">{{ $employee_hr_evaluation ? $employee_hr_evaluation->independence : ''}}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="initiative">Initiative</label></td>
                                                            <td><label for="initiative">{{ $employee_hr_evaluation ? $employee_hr_evaluation->initiative : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="supervision">Supervision</label></td>
                                                            <td><label for="supervision">{{ $employee_hr_evaluation ? $employee_hr_evaluation->supervision : '' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="leadership">Leadership</label></td>
                                                            <td><label for="leadership">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->leadership :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="WOW">WOW</label></td>
                                                            <td><label for="WOW">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->WOW :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="text-align: center;">
                                                        <thead>
                                                        <tr>
                                                            <th rowspan="2">
                                                                <div class="form-group m-form__group">
                                                                    <label for="standards">Standards</label>
                                                                </div>
                                                            </th>
                                                            <th rowspan="6">
                                                                <div class="form-group m-form__group">
                                                                    <label for="scale">Scale</label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><label for="technical_application">Technical Application</label></td>
                                                            <td><label for="technical_application">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->technical_application :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="quality_of_work">Quality of Work</label></td>
                                                            <td><label for="quality_of_work">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->quality_of_work :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="quantity_of_work">Quantity of Work</label></td>
                                                            <td><label for="quantity_of_work">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->quantity_of_work :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="organization_planning">Organization and Planning</label></td>
                                                            <td><label for="organization_planning">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->organization_planning :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="productivity">Productivity</label></td>
                                                            <td><label for="productivity">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->productivity :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="reliability">Reliability</label></td>
                                                            <td><label for="reliability">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->reliability :'' }}</label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="coaching">Coaching</label></td>
                                                            <td><label for="coaching">{{ $employee_hr_evaluation ?  $employee_hr_evaluation->coaching :'' }}</label></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                            </div>
                        </div>

                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Previous Ratings Average</h4>
                                <h6>{{$standards_average}}</h6>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
@endsection