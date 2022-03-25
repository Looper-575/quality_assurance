@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        input[type=file]{
            display: inline;
        }
        #filePreview{
            padding: 10px;
        }
        #filePreview img{
            width: 200px;
            padding: 5px;
        }
        .preview_files {
            height: 35rem;
            width: 100%;
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
                    <h3 class="m-portlet__head-text">Company Policies</h3>
                </div>
                @if($has_permissions->add == 1)
                <div class="float-right mt-3">
                    <a id="add_new_btn" href="javascript:;" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New</span></span>
                    </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" id="html_table">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Added On</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($policies as $index => $policy)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$policy->title}}</td>
                        <td>{{parse_datetime_get($policy->added_on)}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($has_permissions->view == 1)
                                <button type="button" class="btn btn-primary view_btn" title="View Policy" value="{{json_encode($policy)}}"><i class="fa fa-eye"></i></button>
                                @endif
                                @if($has_permissions->update == 1)
                                <button type="button" class="d-none btn btn-primary edit_btn" value="{{json_encode($policy)}}">Edit</button>
                                @endif
                                @if(Auth::user()->role_id == 1)
                                <button type="button" class="btn btn-danger detele_btn" title="Delete Policy" value="{{$policy->policy_id}}"> <i class="fa fa-trash"></i> </button>
                                @endif
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
    <div id="did_form_modal" style="z-index:9999999; height: 100% !important; min-height: 100%; width: 100%; position: fixed; top: 0; background-color: rgba(0, 0, 0, 0.7);display:none;">
        <div style="z-index:99999999;display: block; padding-right: 17px; top: 100px" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog disposition_type_modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Policies</h4>
                        <button type="button" class="btn" onclick="$('#did_form_modal').fadeOut();" aria-hidden="true"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form id="policy_form" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="text" class="form-control mb-4" placeholder="Title" id="title" name="title" required/>
                                <input type="file" id="uploadFile" class="mr-5" accept="application/pdf" name="uploadFile[]" multiple required/>
                                <input type="submit" class="btn btn-success ml-3" name='submitFile' value="Upload"/>
                            </form>
                            <br/>
                            <div id="filePreview" class="text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="preview_files_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="preview_files_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="preview_files_modalLabel">title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="filesPreview"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        var files = new Array();
        $("#uploadFile").change(function(){
            $('#filePreview').html("");
            var total_file=document.getElementById("uploadFile").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#filePreview').append("<iframe src='"+URL.createObjectURL(event.target.files[i])+"'></iframe>");
            }
        });
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('policy_id', id);
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
                    call_ajax('', '{{route('policy_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#type_id').val(null);
            $('#title').val(null);
            $('#number').val(null);
            $('#did_form_modal').fadeIn();
        });
        $('#policy_form').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('policy_form');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('policies_file_upload')}}', data, arr);
        });
        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#type_id').val(data.did_id);
            $('#title').val(data.title);
            $('#number').val(data.number);
            $('#did_form_modal').fadeIn();
        });
        $('.view_btn').click( function () {
            let data = JSON.parse(this.value);
            let APP_URL = {!! json_encode(url('/')) !!}
            $('#filesPreview').html("");
            $('#title').val(data.title);
            let total_file=data.policy_files.length;
            files.length = 0;
            for(let i=0; i<total_file; i++)
            {
                files.push(APP_URL+data.policy_files[i]["file"]);
                $('#filesPreview').append("<iframe class='preview_files' src='"+APP_URL+data.policy_files[i]["file"]+"'></iframe>");
            }
            $('#preview_files_modalLabel').text(data.title);
            $('#preview_files_modal').modal('toggle')
        });
    </script>
@endsection
