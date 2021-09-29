@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" id="">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>User Form</h4>
                    </div>
                    <div class="card-body" id="add_more_cats_data">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input name="first_name"  type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input name="last_name"  type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input name="address"  type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">

                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-danger" id="cancel_action" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    {{-- <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            if (jQuery().select2) {
                $(".select2").select2();
            }
            //form submission;
            $('#product_form').submit(function (e) {
                e.preventDefault();
                let data = new FormData(this);
                let a = function(){ /*window.location.href = '{{ route('') }}';*/ };
                let arr = [a];
                call_ajax_with_functions('','{{ isset($product) ? route('qa.update', $product->product_id) : route('qa.store') }}',data,arr);
            });
            // Cancel action
            $('#cancel_action').click(function (){
                window.location.href="{{route('qa.index')}}";
            });
        });
    </script> --}}
@endsection
