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
                <div class="m-portlet__head-tools float-right">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" href="{{route('employee_form')}}">
                                Add New Employee
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="table table-bordered" id="employee_table_id">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                   <th>Gender</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($employee_lists as $employee_list)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $employee_list->full_name }}</td>
                        <td>{{ $employee_list->email }}</td>
                        <td>{{ $employee_list->designation }}</td>
                        <td>{{ $employee_list->gender }}</td>
                        <td>{{ $employee_list->present_address }}</td>
                        <td>{{ $employee_list->contact_number }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{route('employee_data_view',['employee_id' => $employee_list->employee_id])}}" id="{{$employee_list->employee_id}}" class="btn btn-primary" data-toggle="m-tooltip" data-placement="right" data-skin="dark" data-container="body">
                                    <i class="la la-eye"></i>
                                </a>
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                                <a title="Edit" class="btn text-white bg-warning edit_employee" id="{{$employee_list->employee_id}}" href="{{route('employee_form',['employee_id' => $employee_list->employee_id])}}"><i class="fa fa-edit"></i></a>
                                    @if($employee_list->locked == 0)
                                        <button title="Lock" class="btn btn-info" onclick="lock_employee_record(this);" value="{{$employee_list->employee_id}}"><i class="fa fa-lock"></i></button>
                                    @endif
{{--                                <button title="Delete" class="btn btn-danger" onclick="delete_employee(this);" value="{{$employee_list->employee_id}}"><i class="fa fa-trash"></i></button>--}}
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
        $(document).ready(function() {
            $('#employee_table_id').DataTable( {
            });
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
