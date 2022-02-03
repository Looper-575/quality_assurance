@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .check-size{
            height: 15px;
            width: 15px;
        }
    </style>
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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($managerial_roles as $managerial_role)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$managerial_role->title}}</td>
                        <td>{{$managerial_role->type}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary edit_btn" value="{{json_encode($managerial_role)}}">Edit</button>
                                <button type="button" class="btn btn-danger detele_btn" value="{{$managerial_role->role_id}}"> Delete </button>
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
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="type">Type</label>
                                    <div class="form-group ml-4">
                                        <input
                                            class="form-check-input check-size"
                                            type="checkbox"
                                            name="type[]"
                                            id="type_team_lead"
                                            value="Team Lead"
                                        /><label class="form-check-label pr-4 mt-1 font-14" for="type_team_lead">Team Lead</label>
                                        <input
                                            class="form-check-input check-size"
                                            type="checkbox"
                                            name="type[]"
                                            value="Manager"
                                            id="type_manager"
                                        /><label class="form-check-label pr-4 mt-1 font-14" for="type_manager">Manager</label>
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
                    $(".check-size").prop('checked', false);
                    if(data.length>0){
                        let types = data[0].type.split(',');
                        $.each(types, function(i, val){
                            $("input[value='" + val + "']").prop('checked', true);
                        });
                    }
                });
        }
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
                    call_ajax('', '{{route('managerial_role_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $(".check-size").prop('checked', false);
            $('#role_id').val(null);
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
            $(".check-size").prop('checked', false);
            let data = JSON.parse(this.value);
            let types = data.type.split(',');
            $.each(types, function(i, val){
                $("input[value='" + val + "']").prop('checked', true);
            });
            $('#role_id').val(data.role_id);
            $('#managerial_role_form_modal').fadeIn();
        });
    </script>
@endsection
