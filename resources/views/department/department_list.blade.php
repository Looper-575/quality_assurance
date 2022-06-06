@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName()); ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Departments</h3>
                </div>
                <div class="float-right mt-3">
                    @if($has_permissions->add == 1)
                        <div class="m-portlet__head-tools float-right">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a id="add_new_btn"  data-toggle="modal" data-target="#department_form_modal" class="nav-link m-tabs__link" href="javascript:;">
                                        <span class="add-new-button"><i class="la la-plus"></i><span>Add New</span></span>
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
                    <th>Added By</th>
                    <th>Added On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($types as $type)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$type->title}}</td>
                        <td>{{$type->added_by_user->full_name}}</td>
                        <td>{{parse_datetime_get($type->added_on)}}</td>
                        <td>
                            @if($has_permissions->update == 1)
                                <div class="btn-group btn-group-sm">
                                    <button type="button" title="Edit Team Type" class="btn btn-primary btn-sm edit_btn" value="{{json_encode($type)}}"><i class="la la-edit"></i> </button>
                                    <button type="button" title="Delete Team Type" class="btn btn-danger btn-sm detele_btn" value="{{$type->department_id}}"><i class="la la-trash"></i> </button>
                                </div>
                            @endif
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
    <div class="modal fade" id="department_form_modal" tabindex="-1" role="dialog" aria-labelledby="modal_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="team_type_form">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-check-label" for="title">Title </label>
                                    <input class="form-control" type="text" name="title" placeholder="Title..." id="title" required>
                                    <input class="form-control" type="hidden" name="team_type_id" id="team_type_id" required>
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
    <!--end::Modal-->
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('team_type_id', id);
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
                    call_ajax('', '{{route('team_type_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#team_type_id').val(null);
            $('#title').val(null);
        });
        $('#team_type_form').submit(function (e) {
            e.preventDefault();
            $('#team_type_form_modal').fadeOut();
            let form = document.getElementById('team_type_form');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('team_type_save')}}', data, arr);
        });
        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#team_type_id').val(data.department_id);
            $('#title').val(data.title);
            $('#department_form_modal').modal('show');
        });
    </script>
@endsection
