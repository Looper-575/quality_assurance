@extends('layout.template')
@section('header_scripts')
    <style>
        .note-editor.note-frame .note-editing-area .note-editable{
            height: 200px;
            padding: 30px !important;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="{{asset('assets/vendors/base/vendors.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/demo/default/base/style.bundle.css')}}" rel="stylesheet" type="text/css" />





@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Module Information</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form action="javascript:save_module_info();" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data" method="post" id="save_module_info_form" >
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-check-label" for="project">Project</label>
                            <select class="form-control" name="project" id="project" required >
                                   <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option {{isset($module) ? ($module->project == $project->id ? 'selected' : '' ): ''}}
                                            value="{{$project->id}}">{{$project->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="module" class="form-check-label">Module Name</label>
                        <input required  type="text"  class="form-control" name="module" id="module" value="{{isset($module)?$module->module_name:''}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mt-4">
                        <label for="dependency" class="form-check-label">Dependencies</label>
                        <div class="summernote" id="dependencies">
                            {!!isset($module)?$module->dependencies:''!!}
                        </div>                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="controller" class="form-check-label">Controllers</label>
                        <div class="summernote" id="controllers">
                            {!!isset($module)?$module->controllers:''!!}
                        </div>                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="models" class="form-check-label">Models</label>
                        <div class="summernote" id="models">
                            {!! isset($module)?$module->models:'' !!}
                        </div>                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="views" class="form-check-label">Views</label>
                        <div class="summernote" id="views">
                            {!! isset($module)?$module->views:''!!}
                        </div>                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="description" class="form-check-label">Module Description</label>
                        <div class="summernote" id="description">
                            {!! isset($module)?$module->description:'' !!}
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="module_usage" class="form-check-label">Usage</label>
                        <div class="summernote" id="usage">
                            {!! isset($module)?$module->module_usage:''!!}
                        </div>

                    </div>
                    @if(isset($module))
                        <input name="module_id" type="hidden" value="{{$module->id}}">
                    @endif
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary"> Submit </button>

                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <link href="summernote-bs5.css" rel="stylesheet">
    <script src="summernote-bs5.js"></script>
    <!--end::Base Scripts -->
    <!--begin::Page Resources -->
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
        function save_module_info(){

            let data = new FormData($('#save_module_info_form')[0]);
            data.append('description', $('#description').siblings('.note-editor').find('.note-editable').html());
            data.append('dependency', $('#dependencies').siblings('.note-editor').find('.note-editable').html());
            data.append('controller', $('#controllers').siblings('.note-editor').find('.note-editable').html());
            data.append('models', $('#models').siblings('.note-editor').find('.note-editable').html());
            data.append('views', $('#views').siblings('.note-editor').find('.note-editable').html());
            data.append('module_usage', $('#usage').siblings('.note-editor').find('.note-editable').html());



            let a = function () {
                window.location = "{{route('modules_list')}}";
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('save_module_info')}}',data,arr);
        }
    </script>
@endsection
