@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Sales Transfer Form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form action="{{route('transfersave')}}" class="m-form m-form--fit m-form--label-align-right" enctype="multipart/form-data" method="post" id="transfer_form" >
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="sale_date">Sale Date </label>
                            <input  required  type="date"  class="form-control" name="sale_date" id="sale_date">
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="sales_list" class="form-check-label">Select Sale</label>
                        <select class="form-control" name="sales_list" id="sales_list" required>
                            <option value="0" selected disabled>Account# / Confirmation# / Order#</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="agents_from" class="form-check-label">Transfer From</label>
                        <select class="form-control" name="agents_from" id="agents_from" disabled>
                            <option value="0">Agents</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->user_id }}"> {{ $agent->full_name  }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="agents" class="form-check-label">Transfer to</label>
                        <select class="form-control select2" name="agents" id="agents" required>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->user_id }}"> {{ $agent->full_name  }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary"> Submit </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function (){
            $('.select2').select2();
        });
        $('#sales_list').change(function (e) {
            let agent_id = this.options[this.selectedIndex].getAttribute('data-id');
            $('#agents_from').attr('disabled',false);
            $('#agents_from').val(agent_id);
            $('#agents_from').attr('disabled',true);
        });
        $('#sale_date').change(function (e){
            e.preventDefault();
            let sale_date = $(this).val();
            let data = new FormData();
            data.append('method', 'POST');
            data.append('_token', "{{csrf_token()}}");
            data.append('sale_date', sale_date);
            // console.log(sale_date);
            call_ajax('sales_list', '{{ route('salesmade') }}', data);
        });
        $('#transfer_form').submit(function(e) {
            e.preventDefault();
            let data = new FormData();
            let user_id = $('#agents').val();
            let sales_list = $('#sales_list').val();
            let sales_date = $('#sales_date').val();
            data.append('_token', "{{csrf_token()}}");
            data.append('user_id', user_id);
            data.append('sales_list', sales_list);
            data.append('sales_date', sales_date);
            let a = function () {
                window.location.href = "{{route('sales_transfer_list')}}";
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('transfersave')}}',data,arr);
        });
    </script>
@endsection
