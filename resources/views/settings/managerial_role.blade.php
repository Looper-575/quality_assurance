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
                        <td>
                            @foreach($managerial_role->managerrial_role as $index => $type)
                                @if($index>0),@endif
                                    {{$type->type}}
                            @endforeach
                        </td>
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
    <div class="modal fade" id="managerial_role_form_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Add Managerial Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="managerial_role_form" enctype="multipart/form-data">
                    <div class="modal-body">
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
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        function check_managerial_role(e){
            $.get("{{route('check_managerial_role')}}", { role_id: e.value} )
                .done(function( data ) {
                    $(".check-size").prop('checked', false);
                    if(data.length>0){
                        let types = data;
                        $.each(types, function(i, val){
                            $("input[value='" + val.type + "']").prop('checked', true);
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
            $('#managerial_role_form_modal').modal('show');
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
            let types = data.managerrial_role.type;
            $.each(data.managerrial_role, function(i, val){
                $("input[value='" + val.type + "']").prop('checked', true);
            });
            $('#role_id').val(data.role_id);
            $('#managerial_role_id').val(data.managerial_role_id);
            $('#managerial_role_form_modal').modal('show');
        });
    </script>
@endsection
