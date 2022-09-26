@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Employees List</h3>
                </div>
                @if( Auth::user()->role_id == 1 || Auth::user()->role_id == 5 || ($has_permissions->add == 1 && (Auth::user()->role_id != 1 && Auth::user()->role_id != 5 && count($employee_lists) == 0) ))
                    <div class="float-right mt-3">
                        <div class="m-portlet__head-tools float-right">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a href="{{route('employee_form')}}" class="nav-link m-tabs__link">
                                        <span class="add-new-button"><i class="fa fa-plus"></i><span>Add New Employee</span></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="employee_search_form">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label" for="full_name">Name</label>
                            <input class="form-control mt-2" type="text" name="full_name" id="full_name">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label" for="email">Email</label>
                            <input class="form-control mt-2" type="email" name="email" id="email">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label" for="employment_type">Employment Type</label>
                            <select class="form-control mt-2" name="employment_type" id="employment_type">
                                <option value="">Select Option</option>
                                <option value="Contractual">Contractual</option>
                                <option value="Permanent">Permanent</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label" for="department">Department</label>
                            <select class="form-control mt-2" name="department" id="department">
                                <option value="">All</option>
                                @foreach($departments as $dpt)
                                    <option value="{{$dpt->department_id}}">{{$dpt->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label mb-3" for="role">Role</label>
                            <select class="form-control select2 mt-2" name="role[]" id="role" multiple="multiple">
                                <option value="0">All</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->role_id}}">{{$role->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mt-4">
                        <button type="submit" class="btn btn-primary float-right px-5 mt-3">Search</button>
                    </div>
                </div>
                <hr>
            </form>
            <div id="employee_search_form_data">
                @include('employees.partials.employee_data')
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            $('#employee_table_id').DataTable( {
            });
        });
        $('#employee_search_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('_token', "{{csrf_token()}}")
            let a = function () {
                $('#employee_table_id').DataTable( {
                })
            };
            let arr = [a];
            call_ajax_with_functions('employee_search_form_data', '{{route('employee_search')}}', data, arr);
        });
        function delete_employee (me) {
            let id = me.value;
            let data = new FormData();
            data.append('employee_id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to delete this record? You will not be able to recover this.",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $(me).closest('tr').fadeOut('slow', function (){
                        $(this).remove();
                    });
                    call_ajax('', '{{route('employee_delete')}}', data);
                }
            })
        }
        function lock_employee_record (me){
            let id = me.value;
            let data = new FormData();
            data.append('employee_id', id);
            data.append('_token', "{{csrf_token()}}");
            let a = function () {
                location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('lock_employee_record')}}', data, arr);
        }
    </script>
@endsection
