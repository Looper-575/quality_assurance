@extends('layout.template')
@section('header_scripts')

    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">

@endsection
@section('content')
<!--    --><?php
//    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
//    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Tasks Information</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#pending_tasks" role="tab">
                            Pending Tasks
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#completed_tasks" role="tab">
                           Completed Tasks
                        </a>
                    </li>

                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" href="{{route('task_form')}}" >
                                Task Form
                            </a>
                      </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="pending_tasks" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" id="">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Project</th>
                                <th>Title</th>
                                <th>Department</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Added On</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                 <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pending_tasks as $task)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$task->project->title}}</td>
                                    <td>{{$task->title}}</td>
                                    <td>{{$task->department->title}}</td>
                                    @if(isset($task->users) && $task->users != NULL)
                                        <td>{{$task->users->full_name}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{$task->status==0?'Pending':'Document Submitted'}}</td>
                                    <td>{{parse_datetime_get($task->added_on)}}</td>
                                    <td>{{ parse_datetime_get($task->start_date)}}</td>
                                    <td>{{ parse_datetime_get($task->end_date)}}</td>
                                    <td>

                                        <a class="btn btn-primary" href="{{route('task_form',['id'=>$task->task_id])}}">Edit</a>

                                        <a class="btn btn-info" href="{{route('view_single_task',['id'=>$task->task_id])}}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="completed_tasks" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" id="">
                            <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Title</th>
                                <th>Project</th>
                                <th>Department</th>
                                <th>Assigned To</th>
                                <th>Rating</th>
                                <th>Added On</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($completed_tasks as $task)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$task->project->title}}</td>
                                    <td>{{$task->title}}</td>
                                    <td>{{$task->department->title}}</td>
                                    @if(isset($task->users) && $task->users != NULL)
                                        <td>{{$task->users->full_name}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>{{$task->rating}}</td>
                                    <td>{{parse_datetime_get($task->added_on)}}</td>
                                    <td>{{ parse_datetime_get($task->start_date)}}</td>
                                    <td>{{ parse_datetime_get($task->end_date)}}</td>
                                    <td>
                                        <a class="btn btn-info" href="{{route('view_single_task',['id'=>$task->task_id])}}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
             </div>
        </div>
   </div>

@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>





@endsection
