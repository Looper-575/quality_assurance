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
                <div class="float-right mt-3">
                    <a href="{{route('qa_form')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New</span></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div style="width: 100%">
                <table class="datatable table table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th title="Field #9">Added On</th>
                        <th title="Field #10">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($shifts as $list)
                        <tr>
                            <td>{{ $list->title }}</td>
                            <td>{{ $list->check_in }}</td>
                            <td>{{ $list->check_out }}</td>
                            <td>{{parse_datetime_get($list->added_on)}}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="javascript:view_qa({{$list->shift_id}});"  class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-info" href="{{route('qa_edit' , $list->shift_id)}}" >
                                        <i class="la la-edit"> </i>
                                    </a>
                                    <button type="button" class="btn btn-danger role_delete" ><i class="fa fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th title="Field #9">Added On</th>
                        <th title="Field #10">Action</th>
                    </tr>
                    </tfoot>
                </table>
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
