@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/bundles/select2/dist/css/select2.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Vendors List</h3>
                </div>
                <div class="float-right mt-3">
                    <button type="button" onclick="show_vendor_form();" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        Add New
                    </button>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Did Ids</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user_lists as $user_list)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $user_list->full_name }}</td>
                        <td>{{ $user_list->email }}</td>
                        <td>{{ $user_list->role->title }}</td>
                        <td>{{ $user_list->vendor_did_id}}</td>
                        <td>{{ $user_list->postal_address }}</td>
                        <td>{{ $user_list->contact_number }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button title="Edit" type="button" class="btn btn-primary" onclick="vendor_form(this);" value="{{$user_list->user_id}}"><i class="fa fa-edit"></i></button>
                                <button title="Delete" type="button" class="btn btn-danger" onclick="delete_vendor(this);" value="{{$user_list->user_id}}"><i class="fa fa-trash"></i></button>
                                <button title="Change Password" type="button" class="btn btn-info" onclick="vendor_change_password(this)" value="{{$user_list->user_id}}"><i class="fa fa-key"></i></button>
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
    <!--begin::Modal-->
    <div class="modal fade" id="vendor_form_modal" tabindex="-1" role="dialog" aria-labelledby="vendor_formLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendor_formLabel">Vendor Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="vendor_form_data">
                    @include('vendors.vendor_form')
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
    <!--begin::Modal-->
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
                                <input type="hidden" name="user_id" id="cp_user_id" value="">
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
    <!--end::Modal-->
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
        function show_vendor_form() {
            let data = new FormData();
            data.append('_token', "{{csrf_token()}}");
            let a = function (){
                $('.select2').select2({width: '100%'});
            }
            let b = function () {
                $('#vendor_form_modal').modal('show');
            }
            let arr = [a,b];
            call_ajax_with_functions('vendor_form_data',"{{route('vendor_form')}}",data,arr);
        }
        function save_vendor() {
            if($('#pass').val() !== $('#c_pass').val()){
                $('#pass_response').fadeIn();
                return;
            }
            let data = new FormData($('#vendor_form')[0]);
            let b = function() {
                window.location.reload();
            }
            let arr = [b];
            call_ajax_with_functions('', '{{route('vendor_save')}}', data, arr);
        }
        function delete_vendor (me) {
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
                    call_ajax('', '{{route('vendor_delete')}}', data);
                }
            })
        }
        function vendor_form(me){
            let id = me.value;
            let data = new FormData();
            data.append('user_id', id);
            data.append('_token', "{{csrf_token()}}");
            let a = function (){
                $('.select2').select2({width: '100%'});
            }
            let b = function () {
                $('#vendor_form_modal').modal('show');
            }
            let arr = [a,b];
            call_ajax_with_functions('vendor_form_data',"{{route('vendor_form')}}",data,arr);
        }
        function vendor_change_password(me) {
            $('#cp_user_id').val(me.value);
            $('#change_pass_modal').modal('show');
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
        document.addEventListener("DOMContentLoaded", function(event) {
            $('.select2').select2({
                placeholder: "Select did_ids",
                width: '100%'
            });
        });
    </script>
@endsection
