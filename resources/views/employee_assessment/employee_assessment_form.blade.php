@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                    <h6 class="m-portlet__head-text">
                        @if($is_hrm && $is_manager == false && $EmployeeAssessment == true && $EmployeeAssessment->manager_sign == 1)
                            HR Observations & Comments
                        @elseif($is_manager && $EmployeeAssessment == true || ($is_hrm && $EmployeeAssessment->manager_sign == 0))
                            Department Head/Supervisor Evaluation and Remarks
                        @elseif( ($is_employee || $is_manager || $is_hrm) && $initiated_employee_assessment == true )
                            Employee Self Assessment
                        @else
                            ADMIN VIEW
                        @endif
                            (Employee Assessment)</h6>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Form-->
            <form id="employee_assessment_form" action="javascript:save_employee_assessment()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                @csrf
                <input type="hidden" required name="id" value="{{$EmployeeAssessment ? $EmployeeAssessment->id : 0}}">
                <input type="hidden" required name="employee_id" id="employee_id" >
                @if($is_employee && $initiated_employee_assessment == true )
                    @include('employee_assessment.partials.employee_assessment_employee_form')
                @elseif( ( ($is_admin || ($EmployeeAssessment && $EmployeeAssessment->employees->employee->manager_id == Auth::user()->user_id)) && $EmployeeAssessment->manager_sign == 0)  && ($EmployeeAssessment == true || $initiated_employee_assessment == true))
                    @include('employee_assessment.partials.employee_assessment_manager_form')
                @elseif( ( ($is_admin  || $is_hrm ) && $EmployeeAssessment->hr_sign == 0 && $EmployeeAssessment->manager_sign == 1 ) && $EmployeeAssessment == true)
                    @include('employee_assessment.partials.employee_assessment_hr_form')
                @endif
                @include('employee_assessment.partials.employee_assessment_standards')
                @if($EmployeeAssessment == true && ( $is_admin || $is_hrm ) && !empty($previous_overall_ratings) )
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-bold font-14" for="overall_rating">Previous Evalations Ratings : </label><br>
                                @foreach ($previous_overall_ratings as $overall_rating)
                                    <label class="font-bold font-13" for="overall_rating">{{$overall_rating ? ($loop->index+1)." ) ".$overall_rating : ''}}</label><br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{route('employee_assessment')}}"  class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            get_employee_details();
        });
        let user_id = {{$EmployeeAssessment->user_id}};
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
