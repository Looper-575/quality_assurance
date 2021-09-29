@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <form method="post" id="product_form">
                @csrf
                @if (isset($product))
                    @method('put')
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Product Form</h4>
                    </div>
                    <div class="card-body" id="add_more_cats_data">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input name="title" required type="text" class="form-control"
                                           value="{{ isset($product) ? $product->title : '' }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control select2" name="category_id" >
                                        @foreach($categories as $category)
                                            <option {{ isset($product) && $product->category_id == $category->category_id ? 'selected' : '' }}
                                                    value="{{ $category->category_id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Condition</label>
                                    <select class="form-control select2" name="condition" >
                                        <option {{ isset($product) && $product->condition == 'Used' ? 'selected' : '' }} value="Used">Used</option>
                                        <option {{ isset($product) && $product->condition == 'New' ? 'selected' : '' }} value="New">New</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Value</label>
                                    <input name="value" required type="text" class="form-control"
                                           value="{{ isset($product) ? $product->value : '' }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input name="location" required type="text" class="form-control"
                                           value="{{ isset($product) ? $product->location : '' }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Product Description</label>
                                    <textarea name="description" required type="text" class="form-control description"
                                              style=" height: 86px !important; ">{{ isset($product) ? $product->description : '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Pictures</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input name="images[]" {{ isset($product) ? '' : 'required' }} type="file" accept="image/*"
                                                   class="form-control images">
                                        </div>
                                        <div class="col-6">
                                            <input name="images[]" type="file" accept="image/*"
                                                   class="form-control images">
                                        </div>
                                        <div class="col-6">
                                            <input name="images[]" type="file" accept="image/*"
                                                   class="form-control images">
                                        </div>
                                        <div class="col-6">
                                            <input name="images[]" type="file" accept="image/*"
                                                   class="form-control images">
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
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
    </script>
@endsection
