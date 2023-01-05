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
                    <h3 class="m-portlet__head-text">Leave Bucket List</h3>
                </div>
                @if($is_admin == TRUE)
                    <div class="float-right mt-3">
                        <a href="{{route('leaves_bucket_form')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                            <span><i class="la la-phone-square"></i><span>Add New Leave Bucket</span></span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" style="">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Employee Name</th>
                    <th>Start Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($leaves_bucket)
                    @foreach ($leaves_bucket as $bucket)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $bucket->employee->full_name }}</td>
                            <td>{{ $bucket->start_date }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{route('view_leaves_bucket',['bucket_id' => $bucket->bucket_id, 'user_id' => $bucket->user_id])}}" id="{{$bucket->bucket_id}}" class="btn btn-primary"><i class="la la-eye"></i></a>
                                    @if($is_admin || $is_hr)
                                        <a title="Edit" class="btn btn-primary edit_leaves_bucket" id="{{$bucket->bucket_id}}" href="{{route('leaves_bucket_form',['bucket_id' => $bucket->bucket_id])}}"><i class="fa fa-edit"></i></a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>No Record Found</tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
@endsection
