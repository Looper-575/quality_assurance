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
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                                <h3 class="m-portlet__head-text">Leave Bucket Form</h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form id="leaves_bucket_form" action="javascript:save_leaves_bucket()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                        @csrf
                        <input type="hidden" name="bucket_id" id="bucket_id" value="{{$leaves_bucket ? $leaves_bucket->bucket_id : 0}}">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <div class="col-lg-6">
                                    <label class="form-label">Employee Name:</label>
                                    <select class="form-control" name="user_id" id="user_id" {{($leaves_bucket ? 'disabled' : '')}}  required>
                                        <option value="">Select</option>
                                        @foreach($users as $user)
                                            <option {{ ($leaves_bucket && $leaves_bucket->user_id == $user->user_id)  ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                        @endforeach
                                    </select>
                                    @if($leaves_bucket)
                                        <input type="hidden" name="user_id" id="user_id" value="{{$leaves_bucket->user_id}}">
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Start Date:</label>
                                    <input class="form-control" type="date" name="start_date" value="{{$leaves_bucket ? $leaves_bucket->start_date:''}}">
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-4">
                                    <label class="form-label">Annual leaves:</label>
                                    <input class="form-control" type="number" min="0" max="10" name="annual_leaves" value="{{$leaves_bucket ? $leaves_bucket->annual_leaves:10}}">
                                </div>

                                <div class="col-lg-4">
                                    <label class="form-label">Sick leaves:</label>
                                    <input class="form-control" type="number" min="0" max="5" name="sick_leaves" value="{{$leaves_bucket ? $leaves_bucket->sick_leaves:5}}">
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label">Casual leaves:</label>
                                    <input class="form-control" type="number" min="0" max="4" name="casual_leaves" value="{{$leaves_bucket ? $leaves_bucket->casual_leaves:4}}">
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions--solid">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <button type="submit" class="btn btn-success">
                                            Submit
                                        </button>
                                        <a href="{{route('leaves_bucket')}}"  class="btn btn-primary">
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        function save_leaves_bucket(){
            let a = function () {
                window.location.href = "{{route('leaves_bucket')}}";
            }
            let form_data = new FormData($('#leaves_bucket_form')[0]);
            let arr = [a];
            call_ajax_with_functions('', '{{route('leaves_bucket_save')}}', form_data, arr);
        }
    </script>
@endsection
