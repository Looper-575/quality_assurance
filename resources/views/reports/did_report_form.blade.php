@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Disposition Reports</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="report_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label" for="from">From</label>
                            <input class="form-control" type="date" name="from" id="from" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label" for="to" >To</label>
                            <input class="form-control" type="date" name="to" id="to" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="form-check-label" for="agent">DID</label><br>
                        <select class="form-control select2" required name="did_id[]" id="agent" multiple="multiple">
                            @foreach($dids as $did)
                                <option value="{{$did->did_id}}"> {{$did->title}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-check-label" for="agent">Dispoistion Type</label>
                        <select class="form-control" name="disposition_type" id=disposition_type">
                            <option value="">All</option>
                            @foreach($disposition_types as $disposition_type)
                                <option value="{{$disposition_type->disposition_type_id}}">{{$disposition_type->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
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
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>

        $('#report_form').submit(function (e) {
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
            call_ajax_with_functions('report_data', '{{route('generate_did_report')}}', data, arr);
        });

        function view_lead(me) {
            let data = new FormData();
            data.append('call_id', me.id);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('lead_single_data')}}', data, 'Call Disposition View');
        }

        $(document).ready(function (){
            // toggle sidebar
            setTimeout(function (){
                $('#nav_toggle_btn')[0].click();
            })
            $(".select2").select2();
        },300);
    </script>
@endsection
