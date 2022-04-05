@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Monthly Leaves Taken Report</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="leaves_taken_report_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="user_id">Employee Name</label>
                            <select class="form-control select2 mt-2" name="user_id" id="user_id" required>
                                <option value="">Select Employee</option>
                                @foreach($users as $user)
                                    <option value="{{$user->user_id}}">{{$user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 mt-4">
                        <button type="submit" class="btn btn-primary float-right px-5 mt-2">Generate</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="report_data" class="mt-5"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $('#leaves_taken_report_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('_token', "{{csrf_token()}}")
            let a = function () {
                $('#reports_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf',
                        {
                            extend: 'print',
                            customize: function (win) {
                                $(win.document.body).find('thead').prepend($('#report_header').html());
                            }
                        },
                    ]
                });
            };
            let arr = [a];
            call_ajax_with_functions('report_data', '{{route('generate_monthly_leaves_taken_report')}}', data, arr);
        });
    </script>
@endsection
