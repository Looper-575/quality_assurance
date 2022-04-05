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
                    <a href="{{route('employee_form')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New Employee</span></span>
                    </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th title="Field #1">S.No</th>
                    <th title="Field #2">Name</th>
                    <th title="Field #3">Email</th>
                    <th title="Field #4">Position</th>
                    <th title="Field #5">Gender</th>
                    <th title="Field #6">Address</th>
                    <th title="Field #7">Contact</th>
                    <th title="Field #9">Action</th>
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
{{--                                @if($has_permissions->update == 1 && ((Auth::user()->role_id == 1 || Auth::user()->role_id == 5) || (Auth::user()->role_id != 1 && Auth::user()->role_id != 5 && $isLocked == 0) ) )--}}
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)

                                <a title="Edit" class="btn btn-primary edit_employee" id="{{$employee_list->employee_id}}" href="{{route('employee_form',['employee_id' => $employee_list->employee_id])}}"><i class="fa fa-edit"></i></a>
{{--                                @endif--}}
{{--                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)--}}
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
