@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <style>
        .h3_txt{
            color: #941616;
            text-decoration: underline;
            font-weight: 600;
            width: fit-content;
        }
        .p_color{
            color: #33302f;
            font-size: 18px;
        }

    </style>
    <div class="row my-5 px-5">
        <div class="col-12 d-flex justify-content-end">
            <button onclick="print_div('module_detail')" class="btn btn-success px-5">Print</button>
        </div>
        <div class="col-12">
            <div id="module_detail">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Project Name:</h3>
                        <p class="p_color">{{$module->projects->title}}</p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Module Name:</h3>
                        <p class="p_color">{{$module->module_name}}</p>
                    </div>
                <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Added By:</h3>
                        <p class="p_color">{{$module->users->full_name}}</p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Added On:</h3>
                        <p class="p_color">{{parse_datetime_get($module->added_on)}}</p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Description:</h3>
                        <p class="p_color">
                            {{$module->description}}
                        </p>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Models:</h3>
                        <ul style="list-style-type:disc" class="p_color">
                            @if($module->models != NULL && $module->models != '' )
                                @foreach(explode(',', $module->models) as $model)
                                    <li>
                                        <p class="p_color">{{$model}}</p>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Views:</h3>
                        <ul style="list-style-type:disc" class="p_color">
                            @if($module->views != NULL && $module->views != '' )
                                @foreach(explode(',',$module->views) as $view)
                                <li>
                                    <p class="p_color">{{$view}}</p>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Controllers:</h3>
                        <ul style="list-style-type:disc" class="p_color">
                            @if($module->controllers != NULL && $module->controllers != '' )
                                @foreach(explode(',',$module->controllers) as $controller)
                                <li>
                                    <p class="p_color">{{$controller}}</p>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Dependencies:</h3>
                        <ul style="list-style-type:disc" class="p_color">
                            @if($module->dependencies != NULL && $module->dependencies != '' )
                                @foreach(explode(',',$module->dependencies) as $dependency)
                                <li>
                                    <p class="p_color">{{$dependency}}</p>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <hr class="my-5">
                    <div class="mb-5">
                        <h3 class="h3_txt mb-3">Usage:</h3>
                        <p class="p_color">{{$module->module_usage}}</p>
                    </div>
            </div>
        </div>
    </div>
@endsection
