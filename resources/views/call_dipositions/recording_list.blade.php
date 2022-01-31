@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Call Recordings List</h3>
                </div>
                <div class="float-right mt-3">
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                    @if(isset($recording_list_outgoing) && isset($recording_list_incoming))
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#sale_made_list" role="tab">
                            <i class="" aria-hidden="true"></i>
                            Incoming
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#non_sale_list" role="tab">
                            <i class="" aria-hidden="true"></i>
                            Outgoing
                        </a>
                    </li>
                    @endif
                    @if(isset($recording_list_outgoing_own) && isset($recording_list_incoming_own))
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link {{!isset($recording_list_outgoing)?'active':''}}" data-toggle="tab" href="#own_outgoing_list" role="tab">
                            <i class="" aria-hidden="true"></i>
                            My Incoming
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#own_incoming_list" role="tab">
                            <i class="" aria-hidden="true"></i>
                            My Outgoing
                        </a>
                    </li>
                    @endif
                </ul>

            </div>
        </div>

        <div class="m-portlet__body">

            <div class="tab-content">
                @if(isset($recording_list_outgoing) && isset($recording_list_incoming))
                <div class="tab-pane active" id="sale_made_list" role="tabpanel">
                    <div style="width: 100%">
            <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th title="Field #1">S.No</th>
                    <th title="Field #1">U_ID</th>
                    <th title="Field #3">DID</th>
                    <th title="Field #4">From Number</th>
                    <th title="Field #5">Agent</th>
                    <th title="Field #6">Call Length</th>
                    <th title="Field #7">Recording File</th>
                    <th title="Field #8">Added On</th>
                    <th title="Field #8">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($recording_list_outgoing as $recording)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $recording->uid }}</td>
                        <td>{{ isset($recording->did_numbers->disposition_did)?$recording->did_numbers->disposition_did->title:'' }}</td>
                        <td>{{ $recording->from_number }}</td>
                        <td>{{ $recording->user->full_name??''}}</td>
                        <td>{{ $recording->call_length }}</td>
                        <td>{{ $recording->recording_file_name }}</td>
                        <td>{{ $recording->added_on }}</td>
                        <td>
                            @if($has_permissions->add == 1)
                            <div class="btn-group btn-group-sm">
                                <a href="{{route('dispose' , $recording->rec_id)}}"  class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
                              </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th title="Field #1">S.No</th>
                        <th title="Field #1">U_ID</th>
                        <th title="Field #3">To Number</th>
                        <th title="Field #4">From Number</th>
                        <th title="Field #5">Agent</th>
                        <th title="Field #6">Call Length</th>
                        <th title="Field #7">Recording File</th>
                        <th title="Field #8">Added On</th>
                        <th title="Field #8">Action</th>
                    </tr>
                </tfoot>
            </table>

                    </div>
                </div>
                <div class="tab-pane" id="non_sale_list" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                            <thead>
                            <tr>
                                <th title="Field #1">S.No</th>
                                <th title="Field #1">U_ID</th>

                                <th title="Field #4">From Number</th>
                                <th title="Field #5">Agent</th>
                                <th title="Field #6">Call Length</th>
                                <th title="Field #7">Recording File</th>
                                <th title="Field #8">Added On</th>
                                <th title="Field #8">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($recording_list_incoming as $recording)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $recording->uid }}</td>
                                    <td>{{ $recording->from_number }}</td>
                                    <td>{{ $recording->user->full_name??''}}</td>
                                    <td>{{ $recording->call_length }}</td>
                                    <td>{{ $recording->recording_file_name }}</td>
                                    <td>{{ $recording->added_on }}</td>
                                    <td>
                                        @if($has_permissions->add == 1)
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('dispose' , $recording->rec_id)}}"  class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th title="Field #1">S.No</th>
                                <th title="Field #1">U_ID</th>
                                <th title="Field #4">From Number</th>
                                <th title="Field #5">Agent</th>
                                <th title="Field #6">Call Length</th>
                                <th title="Field #7">Recording File</th>
                                <th title="Field #8">Added On</th>
                                <th title="Field #8">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endif

                @if(isset($recording_list_outgoing_own) && isset($recording_list_incoming_own))
                <div class="tab-pane  {{!isset($recording_list_outgoing)?'active':''}}" id="own_outgoing_list" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                            <thead>
                            <tr>
                                <th title="Field #1">S.No</th>
                                <th title="Field #1">U_ID</th>
                                <th title="Field #3">DID</th>
                                <th title="Field #4">From Number</th>
                                <th title="Field #5">Agent</th>
                                <th title="Field #6">Call Length</th>
                                <th title="Field #7">Recording File</th>
                                <th title="Field #8">Added On</th>
                                <th title="Field #8">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($recording_list_outgoing_own as $recording)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $recording->uid }}</td>
                                    <td>{{ isset($recording->did_numbers->disposition_did)?$recording->did_numbers->disposition_did->title:'' }}</td>
                                    <td>{{ $recording->from_number }}</td>
                                    <td>{{ $recording->user->full_name??''}}</td>
                                    <td>{{ $recording->call_length }}</td>
                                    <td>{{ $recording->recording_file_name }}</td>
                                    <td>{{ $recording->added_on }}</td>
                                    <td>
                                        @if($has_permissions->add == 1)
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('dispose' , $recording->rec_id)}}"  class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th title="Field #1">S.No</th>
                                <th title="Field #1">U_ID</th>
                                <th title="Field #3">To Number</th>
                                <th title="Field #4">From Number</th>
                                <th title="Field #5">Agent</th>
                                <th title="Field #6">Call Length</th>
                                <th title="Field #7">Recording File</th>
                                <th title="Field #8">Added On</th>
                                <th title="Field #8">Action</th>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                <div class="tab-pane" id="own_incoming_list" role="tabpanel">
                    <div style="width: 100%">
                        <table class="datatable table table-bordered" style="">
                            <thead>
                            <tr>
                                <th title="Field #1">S.No</th>
                                <th title="Field #1">U_ID</th>

                                <th title="Field #4">From Number</th>
                                <th title="Field #5">Agent</th>
                                <th title="Field #6">Call Length</th>
                                <th title="Field #7">Recording File</th>
                                <th title="Field #8">Added On</th>
                                <th title="Field #8">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($recording_list_incoming_own as $recording)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $recording->uid }}</td>
                                    <td>{{ $recording->from_number }}</td>
                                    <td>{{ isset($recording->did_numbers->disposition_did)?$recording->did_numbers->disposition_did->title:'' }}</td>
                                    <td>{{ $recording->call_length }}</td>
                                    <td>{{ $recording->recording_file_name }}</td>
                                    <td>{{ $recording->added_on }}</td>
                                    <td>
                                        @if($has_permissions->add == 1)
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('dispose' , $recording->rec_id)}}"  class="btn btn-primary"><i class="fa fa-arrow-right"></i></a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th title="Field #1">S.No</th>
                                <th title="Field #1">U_ID</th>
                                <th title="Field #4">From Number</th>
                                <th title="Field #5">Agent</th>
                                <th title="Field #6">Call Length</th>
                                <th title="Field #7">Recording File</th>
                                <th title="Field #8">Added On</th>
                                <th title="Field #8">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @endif
            </div>

        </div>
    </div>




@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
<script>
        function delete_user (me) {
            let id = me.value;
            let data = new FormData();
            data.append('user_id', id);
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
                    call_ajax('', '{{route('user_delete')}}', data);
                }
            })
        }
    </script>
@endsection
