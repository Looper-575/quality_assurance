@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
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
                        <label for="description" class="form-check-label">Description</label>
                        <textarea   class="form-control " required name="description" id="description"  rows="3">{{isset($module)?$module->description:''}}</textarea>
                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="dependency" class="form-check-label">Dependencies</label>
                        <textarea   class="form-control " required name="dependency" id="dependency"  rows="3">{{isset($module)?$module->dependencies:''}}</textarea>
                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="controller" class="form-check-label">Controllers</label>
                        <textarea   class="form-control " required name="controller" id="controller"  rows="3">{{isset($module)?$module->controllers:''}}</textarea>
                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="models" class="form-check-label">Models</label>
                        <textarea   class="form-control " required name="models" id="models"  rows="3">{{isset($module)?$module->models:''}}</textarea>
                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="views" class="form-check-label">Views</label>
                        <textarea   class="form-control " required name="views" id="views"  rows="3">{{isset($module)?$module->views:''}}</textarea>
                    </div>
                    <div class="col-12 col-md-6 mt-4">
                        <label for="module_usage" class="form-check-label">Usage</label>
                        <textarea   class="form-control " required name="module_usage" id="usage"  rows="3">{{isset($module)?$module->module_usage:''}}</textarea>
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
    <script>
        function save_module_info(){
            let data = new FormData($('#save_module_info_form')[0]);
            let a = function () {
                window.location = "{{route('modules_list')}}";
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('save_module_info')}}',data,arr);
        }
    </script>
@endsection
