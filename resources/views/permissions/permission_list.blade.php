@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .permission-check-box{
            height: 17px;
            width: 17px;
            margin-left: -22px;
            margin-top: 4px;
        }
    </style>
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Permissions</h3>
                </div>
                @if($has_permissions->add == 1)
                <div class="float-right mt-3">
                    <a id="add_new_btn1" href="{{route('add_permissions')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New</span></span>
                    </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" id="html_table">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($permissions as $index => $item)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$item->title}}</td>
                        <td>
                            @if($has_permissions->update == 1)
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-primary edit_btn" title="Edit Menu" href="{{route('edit_permissions',['id' => $item->role_id])}}"><i class="fa fa-edit"></i></a>
                                 <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$item->role_id}}"><i class="fa fa-trash"></i></button>
                            </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="add_new_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="add_new_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-width: 1200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Permissions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="add_data_form_id" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label font-17" for="role">User Role:</label>
                                    <select class="form-control select2" name="role" id="role" required>
                                        <option value="">Select Role </option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->role_id}}">{{$role->title}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-check-label font-17">Menus:</label>
                                    <div class="ml-5">
                                        @foreach($menus as $menu)
                                            <div class="form-check">
                                                <p class="font-20"><span class="mr-5">{{$menu->title}}</span>
                                                    <input
                                                        class="form-check-input permission-check-box"
                                                        type="checkbox"
                                                        name="view_{{$menu->id}}"
                                                        id="view_{{$menu->id}}"
                                                    /><label class="form-check-label pr-5" for="view_{{$menu->id}}"> View</label>
                                                    <input
                                                        class="form-check-input permission-check-box"
                                                        type="checkbox"
                                                        name="add_{{$menu->id}}"
                                                        id="add_{{$menu->id}}"
                                                    /><label class="form-check-label pr-5" for="add_{{$menu->id}}">Add</label>
                                                    <input
                                                        class="form-check-input permission-check-box"
                                                        type="checkbox"
                                                        name="update_{{$menu->id}}"
                                                        id="update_{{$menu->id}}"
                                                    /><label class="form-check-label pr-5" for="update_{{$menu->id}}">Update</label>
                                                </p>
                                            </div>
                                            @if($menu->children !== null)
                                                @foreach($menu->children as $indx => $child)
                                                    <div class="form-check ml-5">
                                                        <p class="font-20"><span class="mr-5">{{$child->title}}</span>
                                                            <input
                                                                class="form-check-input permission-check-box"
                                                                type="checkbox"
                                                                name="view_{{$child->id}}"
                                                                id="view_{{$child->id}}"
                                                            /><label class="form-check-label pr-5" for="view_{{$child->id}}"> View</label>
                                                            <input
                                                                class="form-check-input permission-check-box"
                                                                type="checkbox"
                                                                name="add_{{$child->id}}"
                                                                id="add_{{$child->id}}"
                                                            /><label class="form-check-label pr-5" for="add_{{$child->id}}">Add</label>
                                                            <input
                                                                class="form-check-input permission-check-box"
                                                                type="checkbox"
                                                                name="update_{{$child->id}}"
                                                                id="update_{{$child->id}}"
                                                            /><label class="form-check-label pr-5" for="update_{{$child ->id}}">Update</label>
                                                        </p>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <hr>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" value="" name="permission_id" id="permission_id">
                                <button type="submit"  class="btn btn-primary float-right"> Create</button>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('id', id);
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
                    call_ajax('', '{{route('permission_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#permission_id').val(null);
            $('#title').val(null);
            $('#type').val(null);
            $('#date_from').val(null);
            $('#date_to').val(null);
            $('#add_new_modal').modal('toggle');
        });

        $('#add_data_form_id').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('add_data_form_id');
            let data = new FormData(form);
            let a = function() {
                // window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('save_permissions')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#permission_id').val(data.permission_id);
            $('#title').val(data.title);
            $('#type').val(data.type);
            $('#date_from').val(data.date_from);
            $('#date_to').val(data.date_to);
            $('#add_new_modal').modal('toggle');
        });
    </script>
@endsection
