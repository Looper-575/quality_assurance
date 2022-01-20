@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Holidays</h3>
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
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($holidays as $index => $item)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->date_from}}</td>
                        <td>{{$item->date_to}}</td>
                        <td>{{$item->type}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary edit_btn" title="Edit Menu" value="{{json_encode($item)}}"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$item->holiday_id}}"><i class="fa fa-trash"></i></button>
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
                                    <label class="form-check-label" for="type">Type</label>
                                    <select class="form-control select2" name="type" id="type" required>
                                        <option value="">Select Type </option>
                                        <option value="Muslim">Muslim </option>
                                        <option value="Christian">Christian </option>
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
                    call_ajax('', '{{route('holiday_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#holiday_id').val(null);
            $('#title').val(null);
            $('#type').val(null);
            $('#date_from').val(null);
            $('#date_to').val(null);
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
            let data = JSON.parse(this.value);
            $('#holiday_id').val(data.holiday_id);
            $('#title').val(data.title);
            $('#type').val(data.type);
            $('#date_from').val(data.date_from);
            $('#date_to').val(data.date_to);
            $('#add_new_modal').modal('toggle');
        });
    </script>
@endsection
