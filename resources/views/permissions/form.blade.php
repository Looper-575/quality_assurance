@extends('layout.template')
@section('header_scripts')
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
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Permissions Form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="add_data_form_id" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label font-17 mb-4" for="role">User Role:</label>
                            <input type="hidden" name="role_id" value="{{$role_id}}" {{ $role_id == 0 ? 'disabled' : '' }}>
                            <select class="form-control select2" name="role_id" id="role" required {{ $role_id != 0 ? 'disabled' : '' }}>
                                <option value="">Select Role </option>
                                @foreach($roles as $role)
                                    <option {{ $role_id == $role->role_id ? 'selected' : '' }} value="{{$role->role_id}}">{{$role->title}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-check-label font-17 mb-4">Menus:</label>
                            <div class="ml-5">
                                <div class="m-accordion m-accordion--section m-accordion--padding-lg mb-5">
                                    @foreach($menus as $menu)

                                        <div class="m-accordion__item">
                                            <div class="m-accordion__item-head collapsed" id="m_section_1_content_2_head{{$menu->id}}">
                                    <span class="m-accordion__item-title">
                                        <div class="form-check">
                                        <p class="font-20"><span class="mr-5">{{$menu->title}}</span>
                                            <input
                                                    class="form-check-input permission-check-box"
                                                    type="checkbox"
                                                    name="permission[{{$menu->id}}][0]"
                                                    onclick="open_accordion({{$menu->id}}, this)"
                                                    id="view_{{$menu->id}}"
                                                    value="1"
                                                {{ has_permission_from_db($role_id, $menu->id, 'view') == 1 ? 'checked' : '' }}
                                            />
                                            <label class="form-check-label pr-5" for="view_{{$menu->id}}"> View</label>
                                             @if(count($menu->children) == 0)
                                                <input
                                                        class="form-check-input permission-check-box"
                                                        type="checkbox"
                                                        name="permission[{{$menu->id}}][1]"
                                                        id="add_{{$menu->id}}"
                                                        value="1"
                                                    {{ has_permission_from_db($role_id, $menu->id, 'add') == 1 ? 'checked' : '' }}
                                                /><label class="form-check-label pr-5" for="add_{{$menu->id}}">Add</label>
                                                <input
                                                        class="form-check-input permission-check-box"
                                                        type="checkbox"
                                                        name="permission[{{$menu->id}}][2]"
                                                        id="update_{{$menu->id}}"
                                                        value="1"
                                                    {{ has_permission_from_db($role_id, $menu->id, 'update') == 1 ? 'checked' : '' }}
                                                /><label class="form-check-label pr-5" for="update_{{$menu->id}}">Update</label>
                                            @endif
                                        </p>
                                    </div>
                                    </span>
                                            <span class="m-accordion__item-mode mr-3"></span>
                                            </div>
                                            @if(count($menu->children) > 0)
                                                <div class="m-accordion__item-body collapse {{ has_permission_from_db($role_id, $menu->id, 'view') == 1 ? 'show' : '' }}" id="m_section_1_content_2_body{{$menu->id}}" role="tabpanel" aria-labelledby="m_section_1_content_2_head{{$menu->id}}" data-parent="#m_section_1_content{{$menu->id}}">
                                                    <div class="m-accordion__item-content">
                                                        @foreach($menu->children as $indx => $child)
                                                            <div class="form-check ml-5">
                                                                <p class="font-20"><span class="mr-5">{{$child->title}}</span>
                                                                    <input
                                                                            class="form-check-input permission-check-box"
                                                                            type="checkbox"
                                                                            name="permission[{{$child->id}}][0]"
                                                                            id="view_{{$child->id}}"
                                                                            value="1"
                                                                            {{ has_permission_from_db($role_id, $child->id, 'view') == 1 ? 'checked' : '' }}
                                                                    /><label class="form-check-label pr-5" for="view_{{$child->id}}"> View</label>
                                                                    <input
                                                                            class="form-check-input permission-check-box"
                                                                            type="checkbox"
                                                                            name="permission[{{$child->id}}][1]"
                                                                            id="add_{{$child->id}}"
                                                                            value="1"
                                                                            {{ has_permission_from_db($role_id, $child->id, 'add') == 1 ? 'checked' : '' }}
                                                                    /><label class="form-check-label pr-5" for="add_{{$child->id}}">Add</label>
                                                                    <input
                                                                            class="form-check-input permission-check-box"
                                                                            type="checkbox"
                                                                            name="permission[{{$child->id}}][2]"
                                                                            id="update_{{$child->id}}"
                                                                            value="1"
                                                                            {{ has_permission_from_db($role_id, $child->id, 'update') == 1 ? 'checked' : '' }}
                                                                    /><label class="form-check-label pr-5" for="update_{{$child->id}}">Update</label>
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit"  class="btn btn-primary float-right"> Create</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script>
        function open_accordion(id, e){
            if(e.checked){
                $("#m_section_1_content_2_body"+id).addClass('show');
            }
            else{
                $("#m_section_1_content_2_body"+id).removeClass('show');
            }
        }
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
                    call_ajax('', '{{route('holiday_delete')}}', data);
                }
            })
        });

        $('#add_data_form_id').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('add_data_form_id');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
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
