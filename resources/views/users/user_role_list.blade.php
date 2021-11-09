@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="justify-content: space-between;">
                    <h4>User Roles List</h4>
                    <a class="btn btn-icon icon-left btn-primary" id="add_new_btn" href="javascript:;"><i class="fas fa-plus"></i> Add new</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="chkbox_table">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$role->title}}</td>
                                    <td>{{$role->slug}}</td>
                                    <td>{{parse_datetime_get($role->added_on)}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary edit_btn" value="{{json_encode($role)}}">Edit</button>
                                        <button type="button" class="btn btn-danger detele_btn" value="{{$role->role_id}}"> Delete </button>
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
@endsection
@section('footer_scripts')
    <div id="user_roles_form_modal" style="z-index:9999999; height: 100% !important; min-height: 100%; width: 100%; position: fixed; top: 0; background-color: rgba(0, 0, 0, 0.7);display:none;">
        <div style="z-index:99999999;display: block; padding-right: 17px; top: 100px" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog user_roles_modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">User Role</h4>
                        <button type="button" class="btn" onclick="$('#user_roles_form_modal').fadeOut();" aria-hidden="true"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="user_roles_form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-check-label" for="title">Title </label>
                                        <input class="form-control" type="text" name="title" id="title" required>
                                        <input class="form-control" type="hidden" name="role_id" id="role_id" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit"  class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('role_id', id);
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
                    call_ajax('', '{{route('roles_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#role_id').val(null);
            $('#title').val(null);
            $('#user_roles_form_modal').fadeIn();
        });

        $('#user_roles_form').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('user_roles_form');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('roles_save')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#role_id').val(data.role_id);
            $('#title').val(data.title);
            $('#user_roles_form_modal').fadeIn();

        });

    </script>
@endsection
