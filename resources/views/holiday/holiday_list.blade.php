@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .select2-container{
            width: 100% !important;
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
                    <h3 class="m-portlet__head-text">Holidays</h3>
                </div>
                <div class="float-right mt-3">
                    @if($has_permissions->add == 1)
                        <div class="m-portlet__head-tools float-right">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a id="add_new_btn" class="nav-link m-tabs__link" href="javascript:;">
                                        <span class="add-new-button"><i class="fa fa-plus"></i><span>Add New</span></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" id="html_table">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>No Of Days</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($holidays as $index => $item)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{ parse_date_get($item->date_from) }}</td>
                        <td>{{ parse_date_get($item->date_to) }}</td>
                        <td>{{ $item->holiday_count }}</td>
                        <td>{{ ($item->department_id == 0 ? 'All': $item->department->title) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($has_permissions->update == 1)
                                    <button type="button" class="btn btn-warning edit_btn" title="Edit Menu" value="{{json_encode($item)}}"><i class="fa fa-edit text-white"></i></button>
                                @endif
                                @if(Auth::user()->role_id == 1)
                                    <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$item->holiday_id}}"><i class="fa fa-trash"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="add_new_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="add_new_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Holiday</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="holiday_form_id" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="from">Title</label>
                                    <input class="form-control" type="text" name="title" id="title" placeholder="Title..." value="" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="department_id">Department</label>
                                    <select class="form-control mt-2" name="department_id" id="department_id" required>
                                        <option value="">Please Select</option>
                                        <option value="0">All</option>
                                        @foreach($departments as $dpt)
                                            <option value="{{$dpt->department_id}}">{{$dpt->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label mb-2" for="role_id">Role</label>
                                    <select class="form-control mt-2 select2" name="role_id[]" id="role_id" multiple="multiple" required>
                                        <option value="0">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label mb-2" for="user_id">User</label>
                                    <select class="form-control mt-2 select2" name="user_id[]" id="user_id" multiple="multiple" required>
                                        <option value="0">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="date_from" >Date From</label>
                                    <input class="form-control" type="date" name="date_from" value="" id="date_from" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="date_to" >Date To</label>
                                    <input class="form-control" type="date" name="date_to" value="" id="date_to" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" value="" name="holiday_id" id="holiday_id">
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
        let user_temp = [];
        $(document).ready(function (){
            $(".select2").select2();
        })
        function set_role(department_id, role_id = null)
        {
            $.ajax({
                type:'get',
                url:'get_department_role',
                data:{
                    department_id: department_id,
                },
                success: function( response ) {
                    $('#role_id').empty().append('');
                    var role_id = $('#role_id');
                    role_id.append(
                        $('<option></option>').val(0).html('All')
                    );
                    $.each(response, function(val, data) {
                        role_id.append(
                            $('<option></option>').val(data.role.role_id).html(data.role.title)
                        );
                    });
                }
            }).then(function(){
                if(role_id != null){
                    $("#role_id").select2().select2('val', [role_id]);
                }
            });
        }
        $('#department_id').on('change', function() {
            let department_id = this.value;
            user_temp = [];
            set_role(department_id);
        });
        function get_selected_role_users(role_id, user_id) {
            let department_id = $('#department_id').val();
            if (department_id != '') {
                $.ajax({
                    type: 'get',
                    url: 'get_selected_role_users',
                    data: {
                        role_id: role_id,
                        department_id: department_id,
                    },
                    success: function (response) {
                        $('#user_id').empty().append('');
                        var user_id = $('#user_id');
                        user_id.append(
                            $('<option></option>').val(0).html('All')
                        );
                        $.each(response, function (val, data) {
                            user_id.append(
                                $('<option></option>').val(data.user_id).html(data.full_name)
                            );
                        });
                    }
                }).then(function () {
                    if (user_id != null) {
                        $("#user_id").select2().select2('val', [user_id]);
                    }
                });
            }
        }

        $('#role_id').change( function () {
            let role_id = $(this).val();
            get_selected_role_users(role_id, user_temp);
        });
        $('#date_to').on('change', function () {
            var startDate = new Date($('#date_from').val());
            var endDate = new Date($('#date_to').val());
        });
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
        $('#add_new_btn').click(function () {
            $('#holiday_form_id').resetForm();
            user_temp = [];
            $("#role_id").select2().select2('val', ['']);
            $("#user_id").select2().select2('val', ['']);
            $('#add_new_modal').modal('toggle');
        });

        $('#holiday_form_id').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('holiday_form_id');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('save_holiday')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            user_temp = [];
            let data = JSON.parse(this.value);
            $('#holiday_id').val(data.holiday_id);
            $('#title').val(data.title);
            $('#department_id').val(data.department_id);
            let roles = data.role_id.split(',');
            set_role(data.department_id, roles);
            let users = data.user_id.split(',');
            user_temp = users;
            get_selected_role_users(roles, user_temp);
            $('#date_from').val(data.date_from);
            $('#date_to').val(data.date_to);
            $('#add_new_modal').modal('toggle');
        });
    </script>
@endsection
