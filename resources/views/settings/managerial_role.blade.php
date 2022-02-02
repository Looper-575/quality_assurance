@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Managerial Roles</h3>
                </div>
                <div class="float-right mt-3">
                    <a id="add_new_btn" href="javascript:;" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New</span></span>
                    </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="table table-bordered" id="html_table">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>Added On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($managerial_roles as $managerial_role)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$managerial_role->role->title}}</td>
                        <td>{{$managerial_role->type}}</td>
                        <td>{{parse_datetime_get($managerial_role->added_on)}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary edit_btn" value="{{json_encode($managerial_role)}}">Edit</button>
                                <button type="button" class="btn btn-danger delete_btn" value="{{$managerial_role->managerial_role_id}}"> Delete </button>
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
    <div id="managerial_role_form_modal" style="z-index:9999999; height: 100% !important; min-height: 100%; width: 100%; position: fixed; top: 0; background-color: rgba(0, 0, 0, 0.7);display:none;">
        <div style="z-index:99999999;display: block; padding-right: 17px; top: 100px" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog disposition_type_modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Add Managerial Role</h4>
                        <button type="button" class="btn" onclick="$('#managerial_role_form_modal').fadeOut();" aria-hidden="true"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="managerial_role_form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <select class="form-control" name="role_id" id="role_id" required onchange="check_managerial_role(this)">
                                            <option class="form-control" value="" selected disabled>Plese Select</option>
                                            @foreach($user_roles as $user_role)
                                                <option value="{{$user_role->role_id}}">{{$user_role->title}}</option>
                                            @endforeach
                                        </select>
                                        <input class="form-control" type="hidden" name="managerial_role_id" id="managerial_role_id" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select class="form-control" name="type" id="type" required>
                                            <option class="form-control" value="" selected disabled>Plese Select</option>
                                            <option value="Team Lead">Team Lead</option>
                                            <option value="Manager">Manager</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary float-right">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        function check_managerial_role(e){
            $.get("{{route('check_managerial_role')}}", { role_id: e.value} )
                .done(function( data ) {
                    if(data.length == 0){
                        $("#type option[value='Team Lead']").prop('disabled', false);
                        $("#type option[value='Manager']").prop('disabled', false);
                    }
                    $.each(data, function( index, value ) {
                        if(value.type == 'Manager'){
                            $("#type option[value='Manager']").prop('disabled', true);
                        }
                        if(value.type == 'Team Lead'){
                            $("#type option[value='Team Lead']").prop('disabled', true);
                        }
                    });
                });
        }
        $('.delete_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('managerial_role_id', id);
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
                    call_ajax('', '{{route('managerial_role_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#managerial_role_id').val(null);
            $('#type').val(null);
            $('#role_id').val(null);
            $("#type option[value='Team Lead']").prop('disabled', false);
            $("#type option[value='Manager']").prop('disabled', false);
            $('#managerial_role_form_modal').fadeIn();
        });
        $('#managerial_role_form').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('managerial_role_form');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('managerial_role_save')}}', data, arr);
        });
        $('.edit_btn').click( function () {
            $("#type option[value='Team Lead']").prop('disabled', false);
            $("#type option[value='Manager']").prop('disabled', false);
            let data = JSON.parse(this.value);
            $('#managerial_role_id').val(data.managerial_role_id);
            $('#type').val(data.type);
            $('#role_id').val(data.role_id);
            $('#managerial_role_form_modal').fadeIn();
        });
    </script>
@endsection
