@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Attendance Report</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="attendance_report_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label" for="year_month">Attendance Month</label>
                            <input class="form-control" type="month" name="year_month" id="year_month" required>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label class="form-check-label" for="team" >Team</label>
                            <select class="form-control" name="team" id=team" required>
                                <option value="">Select Team</option>
                                <option value="4">Team Abdullah</option>
                                <option value="6">Team Amroz</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 pb-5">
                        <button type="submit"  class="btn btn-primary float-right"> Generate</button>
                    </div>
                    <br>
                    <div class="col-12">
                        <div id="report_data"></div>
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
        function time_in(e) {
            var user_id = e;
            var time_in = $("#time_in_"+user_id).val();
            var row_id = $("#row_"+user_id).val();

            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: user_id,
                    time_in: time_in,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                }
            });
        }

        function time_out(e) {
            var user_id = e;
            var time_out = $("#time_out_"+user_id).val();
            var row_id = $("#row_"+user_id).val();

            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: user_id,
                    time_out: time_out,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                }
            });
        }

        function mark_late(e) {
            var id = e;
            var row_id = $("#row_"+id).val();

            var late = '';
            if($("#late_"+id).is(':checked') == true){
                late = 1;
                $("#absent_"+id).prop("checked", false);
                $("#absent_"+id).prop("disabled", true);
            }
            else{
                late = 0;
                $("#absent_"+id).prop("disabled", false);
            }
            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    late: late,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                }
            });
        }

        function mark_absent(e) {
            var id = e;
            var row_id = $("#row_"+id).val();

            var absent = '';
            if($("#absent_"+id).is(':checked') == true){
                $("#time_in_"+id).val('');
                $("#time_out_"+id).val('');

                absent = 1;
                $("#late_"+id).prop("checked", false);
                $("#late_"+id).prop("disabled", true);
            }
            else{
                absent = 0;
                $("#late_"+id).prop("disabled", false);
            }

            $.ajax({
                type:'POST',
                url:'mark_attendance',
                data:{
                    _token: "{{ csrf_token()}}",
                    user_id: id,
                    absent: absent,
                    attendance_id: row_id,
                },
                success: function( msg ) {
                    console.log(msg);
                }
            });

        }

        function view_attendance(date) {
            alert(date);
            let data = new FormData();
            data.append('attendance_date', date);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('qa_single_data')}}', data, 'Quality Assessment View');
        }

        $('#attendance_report_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('_token', "{{csrf_token()}}")
            let a = function () {
                $('#reports_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            };
            let arr = [a];
            call_ajax_with_functions('report_data', '{{route('generate_attendance_report')}}', data, arr);
        });
    </script>
@endsection


