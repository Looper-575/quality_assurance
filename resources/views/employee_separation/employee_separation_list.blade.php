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
                    <h3 class="m-portlet__head-text">Employee Separations List</h3>
                </div>
                @if($is_admin == TRUE)
                    <div class="float-right mt-3">
                        <a  href="{{route('separation_form')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            Add Employee Separation
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
                    <th>S.No</th>
                    <th>Employee Name</th>
                    <th>Separation type</th>
                    <th>Notice Period</th>
                    <th>Resignation Date</th>
                    <th>Separation Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($employee_separation as $separation)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td><a href="{{route('employee_data_view',['employee_id' => $separation->user->employee->employee_id])}}">{{ $separation->user->full_name }} </a></td>
                        <td>{{ $separation->type }}</td>
                        <td>{{ $separation->notice_period }}</td>
                        <td>{{ $separation->resignation_date }}</td>
                        <td>{{ $separation->separation_date }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($is_admin)
                                    <a href="{{route('separation_view',['separation_id' => $separation->separation_id])}}" title="View Final Settlement" class="btn btn-primary"><i class="la la-eye"></i></a>
                                    @if($separation->employee_separation)
                                        <button title="Delete Final Settlement" class="btn btn-danger" onclick="delete_final_settlement(this);" value="{{$separation->separation_id}}"><i class="fa fa-trash"></i></button>
                                    @endif
                                    <a href="{{route('separation_form',['separation_id' => $separation->separation_id])}}" title="Employee Separation form" class="btn btn-primary" ><i class="fa fa-edit"></i></a>
                                @endif
                                    <button type="button" onclick="view_undertaking_form(this);" value="{{$separation->separation_id}}" class="btn btn-info">
                                    Undertaking
                                </button>
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
        function delete_final_settlement (me) {
            let id = me.value;
            let data = new FormData();
            data.append('separation_id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to delete Final Settlement!",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes, Delete Final Settlement!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    let a = function () {
                        window.location.reload();
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('delete_final_settlement')}}', data, arr);
                }
            });
        }
        function view_undertaking_form(me) {
            let separation_id = me.value;
            let data = new FormData();
            data.append('_token', '{{csrf_token()}}');
            data.append('separation_id', separation_id);
            call_ajax_modal('POST', '{{route('view_undertaking_form')}}', data, 'View Undertaking Form');
        }
    </script>
@endsection
