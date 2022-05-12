@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
<div class="m-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                            <h6 class="m-portlet__head-text">
                                @if($is_hrm && $EmployeeAssessment == true)
                                    HR Observations & Comments
                                @elseif($is_manager && $EmployeeAssessment == true)
                                    Department Head/Supervisor Evaluation and Remarks
                                @elseif( $EmployeeAssessment == false && ($is_employee || $is_manager || $is_hrm) )
                                    Employee Self Assesment
                                @else
                                    ADMIN VIEW
                                @endif
                                    (Employee Assessment)</h6>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form id="employee_assessment_form" action="javascript:save_employee_assessment()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    @csrf
                    <input type="hidden" required name="id" value="{{$EmployeeAssessment ? $EmployeeAssessment->id : 0}}">
                    <input type="hidden" required name="employee_id" id="employee_id" >
                    <div class="m-portlet__body">
                        @if($EmployeeAssessment == false && ($is_employee || $is_manager || $is_hrm) )
                            @include('employee_assessment.partials.employee_assessment_employee_form')
                        @endif
                        @if( ( ($is_admin && $EmployeeAssessment->manager_sign == 0) || $is_manager) && $EmployeeAssessment == true)
                            @include('employee_assessment.partials.employee_assessment_manager_form')
                        @endif
                        @if( ( ($is_admin && $EmployeeAssessment->hr_sign == 0 && $EmployeeAssessment->manager_sign == 1) || $is_hrm ) && $EmployeeAssessment == true)
                            @include('employee_assessment.partials.employee_assessment_hr_form')
                        @endif
                        <div class="form-group m-form__group row">
                            <div class="col-12">
                                <div class="form-group m-form__group">
                                    <h4 class="text-center">PERFORMANCE EVALUATION STANDARDS SCALE</h4>
                                    <h5>5 Excellent/ Outstanding <small>(Consistently exceeding job requirements)</small></h5>
                                    <h5>4 Good / Exceptional <small>(Exceeding job requirements)</small></h5>
                                    <h5>3 Satisfactory / Meets Job Requirements <small>(Meets Standards / Job requirements)</small></h5>
                                    <h5>2 Need Improvement <small>(Meets some requirements)</small></h5>
                                    <h5>1 Un-Acceptable / Unsatisfactory <small>(Does not meets any job requirements)</small></h5>
                                    <h5>0 Not Applicable</h5>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="{{( ($EmployeeAssessment == true && ( ($is_admin && $EmployeeAssessment->manager_sign == 1) || $is_hrm )) ? 'col-9 pe-0 pr-0' : 'col-12' )}}">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                    <thead>
                                        <tr class="text-center">
                                            <th><label for="standards"><h4>Standards</h4></label></th>
                                            <th><label for="scale"><h4>Scale</h4></label></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><label for="discipline"><h6>Discipline</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="discipline" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->discipline == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="discipline" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->discipline == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="discipline" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->discipline == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="discipline" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->discipline == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="discipline" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->discipline == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="discipline" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->discipline == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="punctuality"><h6>Punctuality</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="punctuality" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->punctuality == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="punctuality" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->punctuality == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="punctuality" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->punctuality == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="punctuality" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->punctuality == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="punctuality" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->punctuality == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="punctuality" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->punctuality == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="work_dedication"><h6>Dedication to Work</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="work_dedication" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->work_dedication == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="work_dedication" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->work_dedication == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="work_dedication" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->work_dedication == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="work_dedication" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->work_dedication == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="work_dedication" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->work_dedication == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="work_dedication" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->work_dedication == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="performance"><h6>Performance</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="performance" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->performance == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="performance" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->performance == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="performance" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->performance == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="performance" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->performance == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="performance" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->performance == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="performance" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->performance == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="peer_behaviour"><h6>Behaviour with Peers</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="peer_behaviour" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->peer_behaviour == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="peer_behaviour" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->peer_behaviour == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="peer_behaviour" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->peer_behaviour == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="peer_behaviour" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->peer_behaviour == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="peer_behaviour" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->peer_behaviour == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="peer_behaviour" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->peer_behaviour == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="customer_handling"><h6>Customer Handling</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_handling" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_handling == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_handling" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_handling == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_handling" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_handling == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_handling" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_handling == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_handling" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_handling == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_handling" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_handling == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="customer_service"><h6>Customer Service</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_service" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_service == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_service" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_service == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_service" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_service == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_service" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_service == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_service" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_service == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="customer_service" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->customer_service == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="job_knowledge"><h6>Job Knowledge</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="job_knowledge" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->job_knowledge == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="job_knowledge" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->job_knowledge == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="job_knowledge" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->job_knowledge == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="job_knowledge" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->job_knowledge == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="job_knowledge" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->job_knowledge == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="job_knowledge" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->job_knowledge == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="technical_application"><h6>Technical Application</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="technical_application" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->technical_application == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="technical_application" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->technical_application == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="technical_application" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->technical_application == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="technical_application" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->technical_application == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="technical_application" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->technical_application == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="technical_application" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->technical_application == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="efficiency"><h6>Efficiency</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="efficiency" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->efficiency == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="efficiency" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->efficiency == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="efficiency" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->efficiency == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="efficiency" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->efficiency == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="efficiency" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->efficiency == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="efficiency" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->efficiency == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="dependability"><h6>Dependability</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="dependability" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->dependability == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="dependability" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->dependability == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="dependability" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->dependability == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="dependability" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->dependability == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="dependability" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->dependability == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="dependability" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->dependability == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="communication"><h6>Communication</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="communication" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->communication == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="communication" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->communication == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="communication" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->communication == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="communication" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->communication == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="communication" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->communication == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="communication" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->communication == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="team_work"><h6>Team Work</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="team_work" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->team_work == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="team_work" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->team_work == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="team_work" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->team_work == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="team_work" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->team_work == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="team_work" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->team_work == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="team_work" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->team_work == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="decision_making"><h6>Decision Making</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="decision_making" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="decision_making" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="decision_making" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="decision_making" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="decision_making" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="decision_making" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="problem_solving"><h6>Problem Solving</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="problem_solving" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="problem_solving" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="problem_solving" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="problem_solving" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="problem_solving" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->decision_making == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="problem_solving" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->problem_solving == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="adaptability"><h6>Adaptability</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="adaptability" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->adaptability == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="adaptability" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->adaptability == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="adaptability" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->adaptability == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="adaptability" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->adaptability == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="adaptability" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->adaptability == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="adaptability" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->adaptability == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="independence"><h6>Independence</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="independence" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->independence == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="independence" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->independence == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="independence" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->independence == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="independence" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->independence == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="independence" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->independence == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="independence" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->independence == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="initiative"><h6>Initiative</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="initiative" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->initiative == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="initiative" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->initiative == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="initiative" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->initiative == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="initiative" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->initiative == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="initiative" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->initiative == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="initiative" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->initiative == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="quality_of_work"><h6>Quality of Work</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quality_of_work" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quality_of_work == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quality_of_work" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quality_of_work == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quality_of_work" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quality_of_work == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quality_of_work" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quality_of_work == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quality_of_work" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quality_of_work == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quality_of_work" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quality_of_work == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="quantity_of_work"><h6>Quantity of Work</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quantity_of_work" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quantity_of_work == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quantity_of_work" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quantity_of_work == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quantity_of_work" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quantity_of_work == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quantity_of_work" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quantity_of_work == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quantity_of_work" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quantity_of_work == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="quantity_of_work" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->quantity_of_work == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="organization_planning"><h6>Organization and Planning</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="organization_planning" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->organization_planning == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="organization_planning" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->organization_planning == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="organization_planning" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->organization_planning == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="organization_planning" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->organization_planning == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="organization_planning" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->organization_planning == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="organization_planning" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->organization_planning == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="productivity"><h6>Productivity</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="productivity" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->productivity == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="productivity" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->productivity == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="productivity" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->productivity == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="productivity" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->productivity == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="productivity" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->productivity == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="productivity" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->productivity == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="reliability"><h6>Reliability</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="reliability" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->reliability == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="reliability" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->reliability == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="reliability" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->reliability == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="reliability" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->reliability == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="reliability" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->reliability == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="reliability" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->reliability == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="attitude"><h6>Attitude</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="attitude" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->attitude == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="attitude" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->attitude == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="attitude" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->attitude == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="attitude" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->attitude == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="attitude" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->attitude == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="attitude" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->attitude == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="WOW"><h6>WOW</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="WOW" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->WOW == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="WOW" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->WOW == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="WOW" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->WOW == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="WOW" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->WOW == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="WOW" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->WOW == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="WOW" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->WOW == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="last_eval_objectives_achieved"><h6>Last Evaluation Objectives Achieved</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="last_eval_objectives_achieved" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->last_eval_objectives_achieved == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="last_eval_objectives_achieved" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->last_eval_objectives_achieved == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="last_eval_objectives_achieved" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->last_eval_objectives_achieved == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="last_eval_objectives_achieved" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->last_eval_objectives_achieved == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="last_eval_objectives_achieved" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->last_eval_objectives_achieved == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="last_eval_objectives_achieved" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->last_eval_objectives_achieved == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                      {{--  FOR MANAGERS ONLY --}}
                                        @if(( $is_admin || $is_manager || $is_hrm))
                                        <tr class="text-center">
                                            <td colspan="2">
                                                <div>
                                                    <h6>TO BE FILLED BY MANAGERS ONLY</h6>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="supervision"><h6>Supervision</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="supervision" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->supervision == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="supervision" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->supervision == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="supervision" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->supervision == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="supervision" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->supervision == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="supervision" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->supervision == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="supervision" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->supervision == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="leadership"><h6>Leadership</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="leadership" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->leadership == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="leadership" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->leadership == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="leadership" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->leadership == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="leadership" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->leadership == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" name="leadership" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->leadership == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="leadership" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->leadership == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="coaching"><h6>Coaching</h6></label></td>
                                            <td>
                                                <div class="m-radio-inline">
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio"  name="coaching" value="5" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->coaching == 5)? 'checked' : ''}} class="form-control">
                                                        Excellent
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio"  name="coaching" value="4" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->coaching == 4)? 'checked' : ''}} class="form-control">
                                                        Good
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio"  name="coaching" value="3" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->coaching == 3)? 'checked' : ''}} class="form-control">
                                                        Satisfactory
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio"  name="coaching" value="2" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->coaching == 2)? 'checked' : ''}} class="form-control">
                                                        Need Improvement
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio"  name="coaching" value="1" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->coaching == 1)? 'checked' : ''}} class="form-control">
                                                        Un-Acceptable
                                                        <span></span>
                                                    </label>
                                                    <label class="m-radio m-radio--solid m-radio--brand">
                                                        <input type="radio" required name="coaching" value="0" {{($EmployeeAssessment and count($EmployeeAssessment->evaluation_standards) > 0 and $EmployeeAssessment->evaluation_standards[0]->coaching == 0)? 'checked' : ''}} class="form-control">
                                                        Not Applicable
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($EmployeeAssessment == true && ( ($is_admin && $EmployeeAssessment->manager_sign == 1) || $is_hrm ) )
                            <div class="col-3 ps-0 pl-0">
                                @include('employee_assessment.partials.evaluation_data')
                            </div>
                            @endif
                        </div>
                        @if($EmployeeAssessment == true && ( $is_admin || $is_hrm ) && !empty($previous_overall_ratings) )
                        <div class="form-group m-form__group row">
                            <div class="col-6">
                                <div class="form-group m-form__group">
                                    <label for="overall_rating">Previous Evalations Ratings : </label><br>
                                    @foreach ($previous_overall_ratings as $overall_rating)
                                        <label for="overall_rating">{{$overall_rating ? ($loop->index+1)." ) ".$overall_rating : ''}}</label><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-success">
                                        Submit
                                    </button>
                                    <a href="{{route('employee_assessment')}}"  class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            get_employee_details();
        });
        let user_id = {{Auth::user()->user_id}};
        function get_employee_details() {
            $.get("{{route('get_employee_details')}}", { user_id: user_id} )
                .done(function( data ) {
                    $('#employee_id').val(data.employee_id);
                    $('#name').html(data.full_name);
                    $('#department').html(data.department.title);
                    $('#designation').html(data.designation);
                });
        }
        function save_employee_assessment(){
            let a = function () {
                window.location.href = "{{route('employee_assessment')}}";
            }
            let form_data = new FormData($('#employee_assessment_form')[0]);
            form_data.append('user_id', user_id);
            form_data.append('employee_id', $('#employee_id').val());
            let arr = [a];
            call_ajax_with_functions('', '{{route('employee_assessment_save')}}', form_data, arr);
        }
    </script>
@endsection