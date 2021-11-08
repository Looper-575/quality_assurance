@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="justify-content: space-between;">
                    <h4>Quality Assurance List</h4>
                    <a class="btn btn-icon icon-left btn-primary" href="{{ route('qa_form') }}">
                        <i class="fas fa-plus"></i> Add new</a>
                </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="chkbox_table">
                                <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Agent</th>
                                    <th>Call Date</th>
                                    <th>Call Type</th>
                                    <th>Call Number</th>
                                    <th>Automatic Fail</th>
                                    <th>Monitor Percentage</th>
                                    <th>Added On</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <?php $i=1 ?>
                                <tbody>
                                    @foreach ($qa_lists as $qa_list)

                                  <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $qa_list->agent->full_name }}</td>
                                        <td>{{ $qa_list->call_date }}</td>
                                        <td>{{ $qa_list->call_type->title }}</td>
                                        <td>{{ $qa_list->call_number }}</td>
                                        <td>{{ $qa_list->automatic_fail_response }}</td>
                                        <td>{{ $qa_list->monitor_percentage }}</td>
                                        <td>{{parse_datetime_get($qa_list->added_on)}}</td>
                                        <td>
                                            <a href="javascript:view_qa({{$qa_list->qa_id}});"  class="btn btn-primary"> Show </a>
                                            {{-- <button type="button"  class="btn btn-danger role_delete" >Delete</button> --}}
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
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script>

        function view_qa(qa_id) {
            let data = new FormData();
            data.append('qa_id', qa_id);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('qa_single_data')}}', data, 'Quality Assessment View');
        }

    </script>
@endsection
