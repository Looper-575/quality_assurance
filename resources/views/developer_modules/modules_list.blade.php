@extends('layout.template')
@section('header_scripts')

    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">

@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Module Information</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#unapproved_modules" role="tab">
                            Pending Modules
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#approved_modules" role="tab">
                            Approved Modules
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#project_modules" role="tab">
                            Project Modules
                        </a>
                    </li>
                    @if($has_permissions->add == 1)
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" href="{{route('module_form')}}">
                            Module Form
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="unapproved_modules" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" id="unapproved_table">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Project</th>
                                <th>Module</th>
                                <th>Added By</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($unapproved_modules)
                                @foreach($unapproved_modules as $unapproved)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$unapproved->projects->title??''}}</td>
                                        <td>{{ $unapproved->task->title??''}}</td>
                                        <td>{{$unapproved->users->full_name??''}}</td>
                                        <td>{{ parse_datetime_get($unapproved->added_on)}}</td>
                                        <td>
                                            @if($has_permissions->view == 1)
                                                <a href="{{route('single_module_detail',$unapproved->id)}}" class="btn btn-primary">View</a>
                                            @endif
                                            @if($unapproved->added_by == Auth::user()->user_id)
                                                <a href="{{route('module_form',['id'=>$unapproved->id])}}" class="btn btn-info">Edit</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="approved_modules" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" id="approved_table">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Project</th>
                                <th>Module</th>
                                <th>Added by</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($approved_modules)
                                @foreach($approved_modules as $approved)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$approved->projects->title??''}}</td>
                                        <td>{{ $approved->task->title??''}}</td>
                                        <td>{{$approved->users->full_name??''}}</td>
                                        <td>{{ parse_datetime_get($approved->added_on)}}</td>
                                        <td>
                                            @if($has_permissions->view == 1)
                                                <a href="{{route('single_module_detail',$approved->id)}}" class="btn btn-primary">View</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="project_modules" role="tabpanel">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-check-label" for="sales_type">Project</label>
                                <select class="form-control" name="project" id="all_projects" required >
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="projects_container" class="col-12 mt-5"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>

    <script>

        function save_module_info(){

            let data = new FormData($('#save_module_info_form')[0]);
            let a = function () {
                window.location.reload();
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('save_module_info')}}',data,arr);

        }

        function approveModule(me){

           let data = new FormData();
            data.append('id', me.id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to Approve this module",
                buttons: [
                    'No',
                    'Yes, Approve Module!'
                ],
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    let a = function () {
                        window.location.reload();
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('approve_module')}}', data, arr);
                }
            });
        }

        $('#all_projects').change(function() {
            let data = new FormData();
            data.append('project_id', $(this).val());
            data.append('_token', "{{csrf_token()}}");
            call_ajax('projects_container',"{{route('project_modules')}}",data)
        });
    </script>

@endsection
