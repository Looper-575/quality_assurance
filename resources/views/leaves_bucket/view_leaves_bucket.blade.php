@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title float-left">
                                <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                                <h3 class="m-portlet__head-text">Leave Bucket Details</h3>
                            </div>
                            <div class="float-right mt-3">
                                <a href="{{route('leaves_bucket')}}"  class="btn btn-primary">
                                    Back
                                </a>
                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-6 pr-5">
                                <label class="">
                                    Employee Name:
                                </label>
                                <span class="float-right">{{ $leaves_bucket->user->full_name }}</span>
                            </div>
                            <div class="col-6 pl-5">
                                <label class="">
                                    Start Date:
                                </label>
                                <span class="float-right">{{ $leaves_bucket->start_date }}</span>
                            </div>
                        </div>
                        <h4>Total Leaves</h4>
                        <div class="row mt-3 pl-5">
                            <div class="col-4">
                                <label for="">Annual Leaves Count: </label>
                                <span>{{ $leaves_bucket->annual_leaves }}</span>
                            </div>
                            <div class="col-4">
                                <label for="">Sick Leaves Count: </label>
                                <span>{{ $leaves_bucket->sick_leaves }}</span>
                            </div>
                            <div class="col-4">
                                <label for="">Casual Leaves Count: </label>
                                <span>{{ $leaves_bucket->casual_leaves }}</span>
                            </div>
                        </div>
                        <h4>Remaining Leaves</h4>
                        <div class="row mt-3 pl-5">
                            <div class="col-4">
                                <label for="">Annual Leaves Count: </label>
                                <span>{{ $remaining_leaves['remaining_annual'] }}</span>
                            </div>
                            <div class="col-4">
                                <label for="">Sick Leaves Count: </label>
                                <span>{{ $remaining_leaves['remaining_sick'] }}</span>
                            </div>
                            <div class="col-4">
                                <label for="">Casual Leaves Count: </label>
                                <span>{{ $remaining_leaves['remaining_casual'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
@endsection
