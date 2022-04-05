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
                        <div class="form-group m-form__group row">
                            <label class="col-lg-6">
                                Employee Name:
                            </label>
                            <div class="col-lg-6">
                                <span>{{ $leaves_bucket->employee->full_name }}</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-6">
                                Start Date:
                            </label>
                            <div class="col-lg-6">
                                <span>{{ $leaves_bucket->start_date }}</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-6">
                                Annual Leaves Count:
                            </label>
                            <div class="col-lg-6">
                                <span>{{ $leaves_bucket->annual_leaves }}</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-6">
                                Sick Leaves Count:
                            </label>
                            <div class="col-lg-6">
                                <span>{{ $leaves_bucket->sick_leaves }}</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-6">
                                Casual Leaves Count:
                            </label>
                            <div class="col-lg-6">
                                <span>{{ $leaves_bucket->casual_leaves }}</span>
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