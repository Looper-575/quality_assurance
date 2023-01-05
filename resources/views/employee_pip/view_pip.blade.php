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
                                <h3 class="m-portlet__head-text">Performance Improvement Plan Details</h3>
                            </div>
                            <div class="float-right mt-3">
                                <a href="{{route('employee_pip')}}"  class="btn btn-primary">
                                    Back
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                        </div>
                    </div>
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">
                                    Employee Name:
                                </label>
                                <div class="col-lg-3">
                                    <span>{{ $pip->employee->full_name }}</span>
                                </div>
                                <label class="col-lg-2 col-form-label">
                                    Manager Name:
                                </label>
                                <div class="col-lg-3">
                                    <span>{{ $pip->manager->full_name }}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">
                                    PIP Duration:
                                </label>
                                <div class="col-lg-3">
                                    <span>{{$pip->pip_from}} - {{$pip->pip_to}}</span>
                                </div>
                                <label class="col-lg-2 col-form-label">
                                    Review Date:
                                </label>
                                <div class="col-lg-3">
                                    <span>{{$pip->review_date}}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="improvement_required">* Define the Task, Skill,
                                    Competency or value that needs to be improved</label>
                                <div class="col-lg-3">
                                    <span>{{$pip->improvement_required}}</span>
                                </div>
                                <label class="col-lg-2 col-form-label" for="action_required">* Define the Action for the
                                    employee to take to improve</label>
                                <div class="col-lg-3">
                                    <span>{{$pip->action_required}}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="needed_resource">* Actions or Resources needed</label>
                                <div class="col-lg-3">
                                    <span>{{$pip->needed_resource}}</span>
                                </div>
                                <label class="col-lg-2 col-form-label" for="target_date">* Target Date</label>
                                <div class="col-lg-3">
                                    <span>{{$pip->target_date}}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="recommendations">* Recommendations</label>
                                <div class="col-lg-3">
                                    <span>{{$pip->recommendations}}</span>
                                </div>
                                <label class="col-lg-2 col-form-label" for="manager_comments">* Manager Comments</label>
                                <div class="col-lg-3">
                                    <span>{{$pip->manager_comments}}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="employee_acknowledgement">* Employee Acknowledgement</label>
                                <div class="col-lg-3">
                                    <span>{{($pip->employee_acknowledgement == 1 ? 'Acknowledged': 'Pending')}}</span>
                                </div>
                                <label class="col-lg-2 col-form-label" for="employee_comments">* Employee Comments</label>
                                <div class="col-lg-3">
                                    <span>{{$pip->employee_comments}}</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="manager_approve">* Manager Approval</label>
                                <div class="col-lg-3">
                                    <span>{{($pip->manager_approve == 1 ? 'Approved': 'Pending')}}</span>
                                </div>
                                <label class="col-lg-2 col-form-label" for="hr_comments">* HR Comments</label>
                                <div class="col-lg-3">
                                    <span>{{($pip->hr_approve == 1 ? 'Approved': 'Pending')}}</span>
                                </div>
                            </div>
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