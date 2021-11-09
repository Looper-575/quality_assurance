@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <form method="post" action="{{route('leave_save')}}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header" style="justify-content: space-between;">
                <h4>leave Application form</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group ">
                            <label class="form-check-label" for="from">From </label>
                            <input required type="date" class="form-control" name="from" id="from" >
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group ">
                            <label class="form-check-label" for="to">To </label>
                            <input required type="date" class="form-control" name="to" id="to" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="leave_type">Leave Type</label>
                            <select class="form-control" name="leave_type"  id="leave_type" required >
                                <option value="" selected disabled >Select</option>
                                @foreach($leave_types as $leave_type)
                                    <option value="{{$leave_type->leave_type_id}}">{{$leave_type->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="half_day" style="display: none" >
                            <label for="half_day" class="form-check-label">Select Half Day</label>
                            <select class="form-control" name="half" id="half_day_option">
                                <option value="" selected disabled>Select</option>
                                <option value="first_half">First Half</option>
                                <option value="second_half">Second Half</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" id="sick_report" >
                            <label class="form-check-label" for="medical_report">Attachement / Mecdical Report</label>
                            <input type="file" class="form-control" name="medical_report" id="medical_report">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label  class="form-check-label" for="no_leaves">No of Leaves</label>
                            <input type="number" class="form-control" name="no_leaves"  id="no_leaves" readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="reason"> Reason </label>
                            <textarea class="form-control " required name="reason" id="reason"  rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"> Submit </button>
                    <button type="reset" class="btn btn-danger"> Reset </button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        $('#leave_type').change(function (){
            if($(this).val() == 3 && $('#no_leaves').val() > 2 ) {
                $("#medical_report").attr("required", true);
                $('#half_day').fadeOut();
                $('#half_day_option').removeAttr('required');
            } else if($(this).val() == 4) {
                $("#medical_report").removeAttr("required");
                $('#half_day').fadeIn();
                $('#half_day_option').attr('required' , true);
            } else {
                $("#medical_report").removeAttr("required");
                $('#half_day').fadeOut();
                $('#half_day_option').removeAttr('required');
            }
        });

        $('#to').change(function (){
            var from_date = $('#from').val();
            var to_date = $('#to').val();
            from_date = from_date.split('-');
            to_date = to_date.split('-');
            from_date = new Date(from_date[0], from_date[1], from_date[2]);
            to_date = new Date(to_date[0], to_date[1], to_date[2]);
            from_date_unixtime = parseInt(from_date.getTime() / 1000);
            to_date_unixtime = parseInt(to_date.getTime() / 1000);
            var timeDifference =    to_date_unixtime - from_date_unixtime;
            var timeDifferenceInHours = timeDifference / 60 / 60;
            var timeDifferenceInDays = timeDifferenceInHours  / 24;
            $('#no_leaves').val(timeDifferenceInDays + 1 );
        });
    </script>
@endsection
