@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Convenience Allowance</h3>
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
                    <th>Name</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user_convenience as $index => $user)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$user->full_name}}</td>
                        <td>{{@$user->role->title}}</td>
                        <td>{{@$user->department->title}}</td>
                        <td>{{$user->gender}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-danger detele_btn" title="Remove Convenience Allowance" value="{{$user->user_id}}"><i class="fa fa-trash"></i></button>
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
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Add Convenience Allowance</h5>
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
                                    <label class="form-check-label" for="user_id">Department</label>
                                    <select class="form-control selectpicker" name="user_id" id="user_id" data-live-search="true" required>
                                        <option value="">Please Select</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->user_id}}">{{$user->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
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
        $(function() {
            $('.selectpicker').selectpicker();
        });
        $('#add_new_btn').click(function () {
            $('#data_form_id').resetForm();
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
            call_ajax_with_functions('', '{{route('add_convenience_allowance')}}', data, arr);
        });
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to remove convenience allowance?",
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
                    call_ajax('', '{{route('remove_convenience_allowance')}}', data);
                }
            })
        });
    </script>
@endsection
