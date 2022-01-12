@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Quality Assurance List</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#qa_queue" role="tab">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                            QA Queue
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#qa_done_list" role="tab">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            QA Done
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" href="{{route('qa_form')}}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            Add New
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">

                <div class="tab-pane active" id="qa_queue" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Call Date</th>
                                <th>Call Number</th>
                                <th>Disposition Type</th>
                                <th title="Field #10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($qa_queue as $qa_list)
                                <tr>
                                    <td>{{ $qa_list->user->full_name }}</td>
                                    <td>{{ $qa_list->added_on }}</td>
                                    <td>{{ $qa_list->phone_number }}</td>
                                    <td>{{$qa_list->call_disposition_types->title}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('qa_add' , $qa_list->call_id)}}"  class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Agent</th>
                                <th>Call Date</th>
                                <th>Call Type</th>
                                <th>Call Number</th>
                                <th title="Field #10">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="qa_done_list" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>Agent</th>
                                <th>Call Date</th>
                                <th>Call Number</th>
                                <th>Automatic Fail</th>
                                <th>Monitor Percentage</th>
                                <th title="Field #9">Added On</th>
                                <th title="Field #10">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($qa_done as $qa_list)
                                <tr>
                                    <td>{{ $qa_list->agent->full_name }}</td>
                                    <td>{{parse_datetime_get($qa_list->call_date)}}</td>
                                    <td>{{ $qa_list->call_number }}</td>
                                    <td>{{ $qa_list->automatic_fail_response }}</td>
                                    @if(isset($qa_list->qa_status))
                                        <td> <span class="badge {{ $qa_list->qa_status->monitor_percentage>60 && $qa_list->qa_status->monitor_percentage<90 ? 'text-dark' : 'text-white' }}" style="background-color:{{$qa_list->qa_status->badge_color}};">{{ $qa_list->qa_status->monitor_percentage }} %</span></td>
                                    @else
                                        <td>NA</td>
                                    @endif
                                    <td>{{parse_datetime_get($qa_list->added_on)}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="javascript:view_qa({{$qa_list->qa_id}});"  class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-info" href="{{route('qa_edit' , $qa_list->qa_id)}}" >
                                                <i class="la la-edit"> </i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Agent</th>
                                <th>Call Date</th>
                                <th>Call Number</th>
                                <th>Automatic Fail</th>
                                <th>Monitor Percentage</th>
                                <th title="Field #9">Added On</th>
                                <th title="Field #10">Action</th>
                            </tr>
                            </tfoot>
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
    <script>
        function view_qa(qa_id) {
            let data = new FormData();
            data.append('qa_id', qa_id);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('qa_single_data')}}', data, 'Quality Assessment View');
        }
    </script>
@endsection


