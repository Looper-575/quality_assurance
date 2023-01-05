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
                    <h3 class="m-portlet__head-text">Call Dispositions Types</h3>
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
                    <th>Added By</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($lists as $call_dispositions_types)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$call_dispositions_types->title}}</td>
                        <td>{{@$call_dispositions_types->added_by_user->full_name}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary edit_btn" value="{{json_encode($call_dispositions_types)}}">Edit</button>
                                <button type="button" class="btn btn-danger detele_btn" value="{{$call_dispositions_types->role_id}}"> Delete </button>
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
    <div id="call_dispositions_types_form_modal" style="z-index:9999999; height: 100% !important; min-height: 100%; width: 100%; position: fixed; top: 0; background-color: rgba(0, 0, 0, 0.7);display:none;">
        <div style="z-index:99999999;display: block; padding-right: 17px; top: 100px" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog disposition_type_modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Add Call Dispositions Types</h4>
                        <button type="button" class="btn" onclick="$('#call_dispositions_types_form_modal').fadeOut();" aria-hidden="true"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="call_dispositions_types_form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="type">Title</label>
                                        <input type="text" name="title" id="title_id" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <input type="hidden" name="disposition_type_id" value="" id="disposition_type_id">
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
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('disposition_type_id', id);
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
                    call_ajax('', '{{route('call_dispositions_types_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $(".check-size").prop('checked', false);
            $('#role_id').val(null);
            $('#call_dispositions_types_form_modal').fadeIn();
        });

        $('#call_dispositions_types_form').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('call_dispositions_types_form');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('call_dispositions_types_save')}}', data, arr);
        });
        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#title_id').val(data.title);
            $('#disposition_type_id').val(data.disposition_type_id);
            $('#call_dispositions_types_form_modal').fadeIn();
        });
    </script>
@endsection
