@extends('layout.template')
@section('header_scripts')
    <style>
        .select2-container{
            width: 100% !important;
        }
        .dependent{
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Deduction</h3>
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
            <table class="datatable table table-bordered" id="html_table">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($deductions as $index => $menu)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$menu->title}}</td>
                        <td>{{ucfirst($menu->type)}}</td>
                        <td>{{$menu->value}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary edit_btn" title="Edit Menu" value="{{json_encode($menu)}}"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$menu->deduction_id}}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="add_new_modal" tabindex="-1" aria-labelledby="add_new_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Deduction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="data_form_id" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-check-label" for="title">Deduction Title</label>
                                    <input class="form-control" type="text" name="title" id="title" value="" required>
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
                                    <label class="form-check-label" for="type">Type</label>
                                    <select class="form-control mt-2" name="type" id="type" required>
                                        <option value="">Please Select</option>
                                        <option value="convenience">Convenience</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="type">Criteria</label>
                                    <select class="form-control mt-2" name="criteria" id="criteria" required>
                                        <option value="">Please Select</option>
                                        <option value="Fixed">Fixed</option>
                                        <option value="Percentage">Percentage %</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="value">Value</label>
                                    <input class="form-control" type="number" name="value" value="" id="value" required>
                                </div>
                            </div>
                            <div class="col-6 before-tax-div">
                                <div class="form-group">
                                    <label class="form-check-label" for="before_tax">Before Tax</label>
                                    <select class="form-control mt-2" name="before_tax" id="before_tax">
                                        <option value="">Please Select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="deduction_id" name="deduction_id" value="">
                                <button type="submit"  class="btn btn-primary float-right"> Save</button>
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
    <script>
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
            set_role(department_id);
        });
        $('#type').on('change', function() {
            let type = this.value;
            if(type == 'convenience'){
                $('#before_tax').prop('required',false);
                $('.before-tax-div').addClass('d-none');
                $('.before-tax-div').removeClass('d-block');
            } else {
                $('#before_tax').prop('required',true);
                $('.before-tax-div').addClass('d-block');
                $('.before-tax-div').removeClass('d-none');
            }
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
                    call_ajax('', '{{route('deduction_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#data_form_id').resetForm();
            $("#role_id").select2().select2('val', [' ']);
            $('#add_new_modal').modal('toggle');
        });

        $('#data_form_id').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('data_form_id');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('save_deduction_form')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#deduction_id').val(data.deduction_id);
            $('#title').val(data.title);
            $('#type').val(data.type);
            $('#value').val(data.value);
            $('#before_tax').val(data.before_tax);
            $('#criteria').val(data.criteria);
            $('#department_id').val(data.department_id);
            let roles = data.role_id.split(',');
            if(data.type == 'convenience'){
                $('#before_tax').prop('required',false);
                $('.before-tax-div').addClass('d-none');
                $('.before-tax-div').removeClass('d-block');
            } else {
                $('#before_tax').prop('required',true);
                $('.before-tax-div').addClass('d-block');
                $('.before-tax-div').removeClass('d-none');
            }
            set_role(data.department_id, roles);
            $('#add_new_modal').modal('toggle');
        });
    </script>
@endsection
