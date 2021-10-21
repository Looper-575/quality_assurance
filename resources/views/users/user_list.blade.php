@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="justify-content: space-between;">
                    <h4>User List</h4>
                    <a class="btn btn-icon icon-left btn-primary" href="javascript:show_form();">
                        <i class="fas fa-plus"></i> Add new</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="chkbox_table">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Manager</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <?php $i=1 ?>
                            <tbody>
                            @foreach ($user_lists as $user_list)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $user_list->full_name }}</td>
                                    <td>{{ $user_list->email }}</td>
                                    <td>{{ $user_list->role->title }}</td>
                                    <td>{{ $user_list->gender }}</td>
                                    <td>{{ $user_list->postal_address }}</td>
                                    <td>{{ $user_list->contact_number }}</td>
                                    <td>{{ isset($user_list->manager->full_name) ? $user_list->manager->full_name : '' }}</td>
                                    <td>
                                        <button title="Edit" class="btn btn-primary edit_user" id="{{$user_list->user_id}}"><i class="fa fa-edit"></i></button>
                                        <button title="Delete" class="btn btn-danger" onclick="delete_user(this);" value="{{$user_list->user_id}}"><i class="fa fa-trash"></i></button>
                                        <button title="Change Password" class="btn btn-info" onclick="change_password(this);" value="{{$user_list->user_id}}"><i class="fa fa-key"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="background_fade" style="z-index:9999999; height: 100% !important; min-height: 100%; width: 100%; position: fixed; top: 0; background-color: rgba(0, 0, 0, 0.7);display:none;">
        <div id="processing" style="z-index:99999999;display: block; padding-right: 17px;" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModal">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="">
                            <div class="form-group">
                                <label>Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Email" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                                    <label class="custom-control-label" for="remember-me">Remember Me</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary m-t-15 waves-effect">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
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
                $('#background_fade_form').fadeOut(function() { $(this).remove(); });
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
        function change_password() {
            $('#change_pass_modal').modal('show');
        }
    </script>
@endsection
