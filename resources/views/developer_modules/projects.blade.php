@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')


    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Projects List</h3>
                </div>
                <div class="float-right mt-3">

                        <a id="add_new_btn" href="javascript:;" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                           Add New Project
                        </a>

                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered">
                            <thead>
                            <tr>

                                <th>#</th>
                                <th>Project</th>
                                <th>Added On</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{ $project->title }}</td>
                                    <td>{{parse_datetime_get($project->added_on)}}</td>
                                    <td>
                                        <button id="{{$project->id}}" onclick="delete_project(this)"  class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
        </div>
    </div>
    <div class="modal fade" id="add_project_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="add_new_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Add Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="project_form_id" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-check-label" for="title">Title</label>
                                    <input class="form-control" type="text" name="title" id="title" value="" required>

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <button type="submit"  class="btn btn-primary"> Save</button>
                                </div>
                            </div>
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
        function delete_project(me){
            let id = me.id;
            let data = new FormData();
            data.append('id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to Delete this Project?",
                icon: "warning",
                buttons: [
                    'No',
                    'Yes, Delete Project!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    let a = function () {
                        window.location.reload();
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('project_delete')}}', data, arr);
                }
            });
        }
        $('#add_new_btn').click(function () {
            $('#title').val('');
            $('#add_project_modal').modal('toggle');
        });

        $('#project_form_id').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('project_form_id');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('project_save')}}', data, arr);
        });
    </script>

@endsection