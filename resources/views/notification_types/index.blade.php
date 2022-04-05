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
                    <h3 class="m-portlet__head-text">Notification Types List</h3>
                </div>
                @if($is_admin == TRUE)
                    <div class="float-right mt-3">
                         <a class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill"
                         href="javascript:show_notification_type_form();"><i class="fas fa-plus"></i> Add Notification Type</a>
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
                    <th title="Field #2">Notification Type</th>
                    <th title="Field #8">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($notification_types as $notification_type)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $notification_type->type }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                   <button onclick="javascript:view_notification_type(this);" value="{{$notification_type->notification_type_id}}"  class="btn btn-primary"><i class="la la-eye"></i></button>
                                @if($is_admin)
                                   <button onclick="javascript:edit_notification_type(this);" value="{{$notification_type->notification_type_id}}" class="btn btn-primary edit_notification_type" ><i class="fa fa-edit"></i></button>
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
        function show_notification_type_form(){
             let data = new FormData();
             data.append('_token', '{{csrf_token()}}');
             call_ajax_modal('POST', '{{route('notification_type_form')}}', data, 'Add Notification Type');
        }
        function edit_notification_type(me){
            let notification_type_id = me.value;
            let data = new FormData();
            data.append('_token', '{{csrf_token()}}');
            data.append('notification_type_id', notification_type_id);
            call_ajax_modal('POST', '{{route('notification_type_form')}}', data, 'Edit Notification Type');
        }
        function view_notification_type(me){
            let notification_type_id = me.value;
            let data = new FormData();
            data.append('_token', '{{csrf_token()}}');
            data.append('notification_type_id', notification_type_id);
            call_ajax_modal('POST', '{{route('view_notification_type')}}', data, 'View Notification Type');
        }
        function save_notification_type(){
            let a = function () {
                window.location.href = "{{route('notification_types')}}";
            }
            let form_data = new FormData($('#notification_type_form')[0]);
            let arr = [a];
            call_ajax_with_functions('', '{{route('notification_type_save')}}', form_data, arr);
        }
    </script>
@endsection
