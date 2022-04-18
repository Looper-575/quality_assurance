@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Users List</h3>
                </div>
                <div class="float-right mt-3">
                    <a href="javascript:show_form();" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New</span></span>
                    </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th title="Field #1">S.No</th>
                    <th title="Field #2">Name</th>
                    <th title="Field #3">Email</th>
                    <th title="Field #4">Role</th>
                    <th title="Field #5">Vicidialer id</th>
                    <th title="Field #6">Gender</th>
                    <th title="Field #7">Address</th>
                    <th title="Field #8">Contact</th>
                    <th title="Field #9">Manager</th>
                    <th title="Field #10">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user_lists as $user_list)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $user_list->full_name }}</td>
                        <td>{{ $user_list->email }}</td>
                        <td>{{ $user_list->role->title }}</td>
                        <td>{{ $user_list->vicidialer_id ? $user_list->vicidialer_id : 'N/A' }}</td>
                        <td>{{ $user_list->gender }}</td>
                        <td>{{ $user_list->postal_address }}</td>
                        <td>{{ $user_list->contact_number }}</td>
                        <td>{{ isset($user_list->manager->full_name) ? $user_list->manager->full_name : '' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button title="Edit" class="btn btn-primary edit_user" id="{{$user_list->user_id}}"><i class="fa fa-edit"></i></button>
                                <button title="Delete" class="btn btn-danger" onclick="delete_user(this);" value="{{$user_list->user_id}}"><i class="fa fa-trash"></i></button>
                                <button title="Change Password" class="btn btn-info" onclick="change_password(this);" value="{{$user_list->user_id}}"><i class="fa fa-key"></i></button>
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
    <div class="modal fade" id="change_pass_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="change_pass_form">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="change_password">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                </div>
                                @csrf
                                <input type="text" id="change_password" class="form-control" placeholder="Password" name="password">
                                <input type="hidden" name="user_id" id="c_user_id">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        function show_form(){
            let data = new FormData();
            data.append('_token', '{{csrf_token()}}');
            call_ajax_modal('post', '{{route('user_form')}}', data, 'Add New User');
        }
        function save_user() {
            if($('#pass').val() !== $('#c_pass').val()){
                $('#pass_response').fadeIn();
                return;
            }
            let form = document.getElementById('user_form');
            let data = new FormData(form);
            let a = function () {
                $('#background_fade_form').modal('hide');
            }
            let b = function() {
                window.location.reload();
            }
            let arr = [a,b];
            call_ajax_with_functions('', '{{route('user_save')}}', data, arr);
        }

        $('.edit_user').click(function () {
            let data = new FormData();
            data.append('user_id', this.id);
            data.append('_token', '{{csrf_token()}}');
            call_ajax_modal('post', '{{route('user_form')}}', data, 'Edit User');
        });
        function delete_user (me) {
            let id = me.value;
            let data = new FormData();
            data.append('user_id', id);
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
                    call_ajax('', '{{route('user_delete')}}', data);
                }
            })
        }
        function change_password(me) {
            $('#change_pass_modal').modal('show');
            $('#c_user_id').val(me.value);
        }
        $('#change_pass_form').submit(function (e){
            e.preventDefault();
            let data = new FormData(this);
            let a = function () {
                $('#change_pass_modal').modal('hide');
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('change_password')}}', data, arr);
        });
    </script>
@endsection
