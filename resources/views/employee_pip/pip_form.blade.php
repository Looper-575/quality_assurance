@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
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
        <div class="m-portlet__body">
            <!--begin::Form-->
            <form id="pip_detail_form" action="javascript:save_pip_details()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                @csrf
                <input type="hidden" name="pip_id" id="pip_id" value="{{$pip ? $pip->pip_id : 0}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label> Manager Name:  </label>
                            <?php
                            $user_ddl_perm = ( ((Auth::user()->role->role_id == '5' or Auth::user()->role->role_id == '1') || (Auth::user()->role->role_id != '5' && Auth::user()->role->role_id != '1' && $is_manager == 1)) && $pip );
                            ?>
                            <select class="form-control" name="manager_id" id="manager_id" onchange="get_manager_users_data(this)" required {{ ($user_ddl_perm || $is_manager == 1) ? 'disabled' : '' }}>
                                <option value="">Select</option>
                                @foreach($om as $user)
                                    <option {{$pip ? ($pip->manager_id == $user->user_id ? 'selected': '') : ($user->user_id == Auth::user()->user_id ? 'selected' : '')}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                @endforeach
                            </select>
                            @if( ($user_ddl_perm || $is_manager == 1) )
                                <input type="hidden" name="manager_id" value="{{$pip ? $pip->manager_id : Auth::user()->user_id}}">
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="font-bold">* Start Date</label>
                            <input name="pip_from" id="pip_from" value="{{$pip ? $pip->pip_from : ''}}" required type="date"
                                   class="form-control" placeholder="from date">
                        </div>
                        <div class="form-group">
                            <label for="target_date">* Target Date</label>
                            <input name="target_date" id="target_date" value="{{$pip ? $pip->target_date : ''}}" required type="date"
                                   class="form-control" placeholder="to date">
                        </div>
                        <div class="form-group">
                            <label for="action_required">* Define the Action for the
                                employee to take to improve</label>
                            <textarea name="action_required" id="action_required"
                                      rows="3" style="width: 100%; max-width: 100%;"
                                      required class="form-control">{{$pip ? $pip->action_required : ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="recommendations">* Recommendations</label>
                            <textarea name="recommendations" id="recommendations"
                                      rows="3" style="width: 100%; max-width: 100%;"
                                      required class="form-control">{{$pip ? $pip->recommendations : ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="manager_comments">* Manager Comments</label>
                            <textarea name="manager_comments" id="manager_comments"
                                      rows="3" style="width: 100%; max-width: 100%;"
                                      required class="form-control">{{$pip ? $pip->manager_comments : ''}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label> Employee Name: </label>
                            <select class="form-control" name="user_id" id="user_id" required {{$user_ddl_perm ? 'disabled' : ''}}>
                                <option value="">Select</option>
                                @foreach($employee as $user)
                                    <option {{$pip ? ($pip->user_id == $user->user_id ? 'selected': '') : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                @endforeach
                                @if( $user_ddl_perm )
                                    <input type="hidden" name="user_id" value="{{$pip ? $pip->user_id : ''}}">
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-bold">* End Date</label>
                            <input name="pip_to" id="pip_to" value="{{$pip ? $pip->pip_to : ''}}" required type="date"
                                   class="form-control" placeholder="to date">
                        </div>
                        <div class="form-group">
                            <label>Review Date:</label>
                            <input name="review_date" id="review_date" value="{{$pip ? $pip->review_date : ''}}" required type="date"
                                   class="form-control" placeholder="from date">
                        </div>
                        <div class="form-group">
                            <label for="improvement_required">* Define the Task, Skill,
                                Competency or value that needs to be improved</label>
                            <textarea name="improvement_required" id="improvement_required"
                                      rows="3" style="width: 100%; max-width: 100%;"
                                      required class="form-control">{{$pip ? $pip->improvement_required : ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="needed_resource">* Actions or Resources needed</label>
                            <textarea name="needed_resource" id="needed_resource"
                                      rows="3" style="width: 100%; max-width: 100%;"
                                      required class="form-control">{{$pip ? $pip->needed_resource : ''}}</textarea>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit" class="btn btn-success">
                            Submit
                        </button>
                        <a href="{{route('employee_pip')}}"  class="btn btn-primary">
                            Back
                        </a>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
    <!--end::Portlet-->
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        function get_manager_users_data(e){
            $.get("{{route('get_manager_users_data')}}", { manager_id: e.value} )
                .done(function( data ) {
                    let employee_options = '<option value="">Select</option>';
                    $.each(data.employee, function(i, item) {
                        employee_options += '<option value="'+item.user_id+'">'+item.full_name+'</option>';
                    });
                    $('#user_id').html(employee_options);
                });
        }
        function save_pip_details(){
            let a = function () {
                window.location.href = "{{route('employee_pip')}}";
            }
            let form_data = new FormData($('#pip_detail_form')[0]);
            let arr = [a];
            call_ajax_with_functions('', '{{route('pip_save')}}', form_data, arr);
        }
        $( document ).ready(function() {
            $('#pip_to').change(function() {
                let pip_from = new Date($('#pip_from').val());
                let pip_to = new Date($('#pip_to').val());
                if (pip_from > pip_to){
                    alert('PIP to date should be equal to / greater then PIP from date');
                    let day = ("0" + pip_from.getDate()).slice(-2);
                    let month = ("0" + (pip_from.getMonth() + 1)).slice(-2);
                    let pip_to = pip_from.getFullYear()+"-"+(month)+"-"+(day);
                    $('#pip_to').val(pip_to);
                }
            });
            $('#target_date').change(function() {
                let target_date = new Date($(this).val());
                let pip_to = new Date($('#pip_to').val());
                if (target_date < pip_to){
                    alert('PIP Target date should be equal to / greater then PIP to date');
                    let day = ("0" + pip_to.getDate()).slice(-2);
                    let month = ("0" + (pip_to.getMonth() + 1)).slice(-2);
                    let target_date = pip_to.getFullYear()+"-"+(month)+"-"+(day);
                    $('#target_date').val(target_date);
                }
                let new_date = new Date(target_date.setDate(target_date.getDate() + 7));
                let day = ("0" + new_date.getDate()).slice(-2);
                let month = ("0" + (new_date.getMonth() + 1)).slice(-2);
                let nextWeekDate = new_date.getFullYear()+"-"+(month)+"-"+(day);
                console.log(nextWeekDate);
                if($('#pip_id').val() == 0){
                    $('#review_date').val(nextWeekDate);
                }
            });
            $('#review_date').change(function() {
                let review_date = new Date($('#review_date').val());
                let target_date = new Date($('#target_date').val());
                if (target_date > review_date){
                    alert('PIP Review date should be atleast equal to PIP Target date');
                    let day = ("0" + target_date.getDate()).slice(-2);
                    let month = ("0" + (target_date.getMonth() + 1)).slice(-2);
                    let review_date = target_date.getFullYear()+"-"+(month)+"-"+(day);
                    $('#review_date').val(review_date);
                }
            });
        });
    </script>
@endsection