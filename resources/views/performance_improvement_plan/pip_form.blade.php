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
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                                <h3 class="m-portlet__head-text">Performance Improvement Plan Form</h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form id="pip_detail_form" action="javascript:save_pip_details()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                        @csrf
                        <input type="hidden" name="pip_id" id="pip_id" value="{{$pip ? $pip->pip_id : 0}}">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label">
                                    Operation Manager Name:
                                </label>
                                <?php
                                $user_ddl_perm = ( ((Auth::user()->role->role_id == '5' or Auth::user()->role->role_id == '1') || (Auth::user()->role->role_id != '5' && Auth::user()->role->role_id != '1' && $is_om == 1)) && $pip );
                                ?>
                                <div class="col-lg-3">
                                    <select class="form-control" name="om_id" id="om_id" onchange="get_om_users_data(this)" required {{ ($user_ddl_perm || $is_om == 1) ? 'disabled' : '' }}>
                                        <option value="">Select</option>
                                        @foreach($om as $user)
                                            <option {{$pip ? ($pip->om_id == $user->user_id ? 'selected': '') : ($user->user_id == Auth::user()->user_id ? 'selected' : '')}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                        @endforeach
                                    </select>
                                    @if( ($user_ddl_perm || $is_om == 1) )
                                        <input type="hidden" name="om_id" value="{{$pip ? $pip->om_id : Auth::user()->user_id}}">
                                    @endif
                                </div>
                                <label class="col-lg-2 col-form-label">
                                    Staff Name:
                                </label>
                                <div class="col-lg-3">
                                    <select class="form-control" name="staff_id" id="staff_id" required {{$user_ddl_perm ? 'disabled' : ''}}>
                                        <option value="">Select</option>
                                        @foreach($staff as $user)
                                            <option {{$pip ? ($pip->staff_id == $user->user_id ? 'selected': '') : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                        @endforeach
                                        @if( $user_ddl_perm )
                                        <input type="hidden" name="staff_id" value="{{$pip ? $pip->staff_id : ''}}">
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-1 col-form-label">
                                    PIP Duration:
                                </label>
                                <div class="col-lg-5 d-flex">
                                    <span>From</span>
                                    <input name="pip_from" value="{{$pip ? $pip->pip_from : ''}}" required type="date"
                                           class="form-control" placeholder="from date">
                                    <span>To</span>
                                    <input name="pip_to" value="{{$pip ? $pip->pip_to : ''}}" required type="date"
                                           class="form-control" placeholder="to date">
                                </div>
                                <label class="col-lg-2 col-form-label">
                                    Review Date:
                                </label>
                                <div class="col-lg-3">
                                    <input name="review_date" value="{{$pip ? $pip->review_date : ''}}" required type="date"
                                           class="form-control" placeholder="from date">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="improvement_required">* Define the Task, Skill,
                                    Competency or value that needs to be improved</label>
                                <div class="col-lg-3">
                                    <textarea name="improvement_required" id="improvement_required" cols="40" rows="20" required class="form-control">
                                        {{$pip ? $pip->improvement_required : ''}}</textarea>
                                </div>
                                <label class="col-lg-2 col-form-label" for="action_required">* Define the Action for the
                                    staff member to take to improve</label>
                                <div class="col-lg-3">
                                    <textarea name="action_required" id="action_required" cols="40" rows="20" required class="form-control">
                                        {{$pip ? $pip->action_required : ''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="needed_resource">* Actions or Resources needed</label>
                                <div class="col-lg-3">
                                    <textarea name="needed_resource" id="needed_resource" cols="40" rows="20" required class="form-control">
                                        {{$pip ? $pip->needed_resource : ''}}</textarea>
                                </div>
                                <label class="col-lg-2 col-form-label" for="target_date">* Target Date</label>
                                <div class="col-lg-3">
                                    <input name="target_date" value="{{$pip ? $pip->target_date : ''}}" required type="date"
                                           class="form-control" placeholder="to date">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-2 col-form-label" for="recommendations">* Recommendations</label>
                                <div class="col-lg-3">
                                    <textarea name="recommendations" id="recommendations" cols="40" rows="20" required class="form-control">
                                        {{$pip ? $pip->recommendations : ''}}</textarea>
                                </div>
                                <label class="col-lg-2 col-form-label" for="om_comments">* OM Comments</label>
                                <div class="col-lg-3">
                                    <textarea name="om_comments" id="om_comments" cols="40" rows="20" required class="form-control">
                                        {{$pip ? $pip->om_comments : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions--solid">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <button type="submit" class="btn btn-success">
                                            Submit
                                        </button>
                                        <a href="{{route('performance_improvement_plan')}}"  class="btn btn-primary">
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        function get_om_users_data(e){
            $.get("{{route('get_om_users_data')}}", { om_id: e.value} )
                .done(function( data ) {
                    let staff_options = '<option value="">Select</option>';
                    $.each(data.staff, function(i, item) {
                        staff_options += '<option value="'+item.user_id+'">'+item.full_name+'</option>';
                    });
                    $('#staff_id').html(staff_options);
                });
        }
        function save_pip_details(){
            let a = function () {
                window.location.href = "{{route('performance_improvement_plan')}}";
            }
            let form_data = new FormData($('#pip_detail_form')[0]);
            let arr = [a];
            call_ajax_with_functions('', '{{route('pip_save')}}', form_data, arr);
        }
    </script>
@endsection