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
                    <h4>Call Disposition List</h4>
                    <a class="btn btn-icon icon-left btn-primary" href="{{route('lead_form')}}">
                        <i class="fas fa-plus"></i> Add new</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="chkbox_table">
                            <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Added On</th>
                                <th>DID</th>
                                <th>Service Address</th>
                                <th>Phone Number</th>
                                <th>Customer Name</th>
                                <th>Order Number</th>
                                <th>Account Number</th>
                                <th>Provider Name</th>
                                <th>Services Sold</th>
                                <th>Agent Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <?php $i=1 ?>
                            <tbody>
                            @foreach ($call_disp_lists as $call_disp_list)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ parse_datetime_get($call_disp_list->added_on) }}</td>
                                    <td>{{ $call_disp_list->did }}</td>
                                    <td>{{ $call_disp_list->service_address }}</td>
                                    <td>{{ $call_disp_list->phone_number }}</td>
                                    <td>{{ $call_disp_list->customer_name }}</td>
                                    <td>{{ $call_disp_list->order_number }}</td>
                                    <td>{{ $call_disp_list->account_number }}</td>
                                    <?php
                                    $providers=null;
                                    for($i=0; $i<count($call_disp_list->call_dispositions_services); $i++) {
                                        $providers .= $call_disp_list->call_dispositions_services[$i]->provider_name.', ';
                                    }
                                    ?>
                                    <td>{{ $providers }}</td>
                                    <td>{{ $call_disp_list->services_sold }}</td>
                                    <td>{{ $call_disp_list->user->full_name }}</td>
                                    <td>
                                        <button type="button" onclick="view_lead(this)" value="{{$call_disp_list->call_id}}" class="btn btn-info"> Show </button>
                                        <a class="btn btn-primary" href="{{route('lead_edit' , $call_disp_list->call_id)}}"> Edit </a>
                                        <button type="button" onclick="delete_lead(this);" value="{{$call_disp_list->call_id}}" class="btn btn-danger" >Delete</button>
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
        function delete_lead (me) {
            let id = me.value;
            let data = new FormData();
            data.append('call_id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to delete this record? You will not be able to recover this.",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $(me).closest('tr').fadeOut('slow', function (){
                        $(this).remove();
                    });
                    call_ajax('', '{{route('lead_delete')}}', data);
                }
            })
        }
        function view_lead() {

        }
    </script>
@endsection