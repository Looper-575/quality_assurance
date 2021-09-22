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
                    <h4>Products List</h4>
                    <a class="btn btn-icon icon-left btn-primary" href="{{ route('users') }}">
                        <i class="fas fa-plus"></i> Add new</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="chkbox_table">
                            <thead>
                            <tr>
                                <th class="text-center pt-3">
                                    <div class="custom-checkbox custom-checkbox-table custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                               class="custom-control-input" id="checkbox-all">
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Images</th>
                                <th>Added On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)

                                <tr>
                                    <td class="text-center pt-2">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input p_check"
                                                   id="pid_{{ $product->product_id }}" value="{{ $product->product_id }}">
                                            <label for="pid_{{ $product->product_id }}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->category->title }}</td>
                                    <td>{{ $product->location }}</td>
                                    <td>
                                        <?php $images = explode(',' , $product->images); ?>
                                        @foreach($images as $image)
                                            <img alt="image" src="{{ asset('product_images/'.$image) }}" width="35">
                                        @endforeach
                                    </td>
                                    <td>{{ $product->added_on }}</td>
                                    <td>
                                        <div class="badge badge-success badge-shadow">Completed</div>
                                    </td>
                                    <td>
                                        <button type="button" value="{{ $product->product_id }}" title="Details"
                                                class="btn btn-warning view_action"><i class="fas fa-eye"></i></button>
                                        @if ($product->status == 2)
                                            <button type="button" title="Approve" value="{{ $product->product_id }}"
                                                    class="btn btn-success approve_action"><i class="fas fa-check"></i></button>
                                            <button type="button" title="Reject" value="{{ $product->product_id }}"
                                                    class="btn btn-danger reject_action"><i class="fas fa-times"></i></button>
                                            <a href="{{ route('qa.edit', $product->product_id) }}" title="Edit" class="btn btn-info edit_action">
                                                <i class="fas fa-edit"></i></a>
                                        @endif
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
        $( document ).ready(function() {
            // Approve action
            $('.approve_action').click(function (){
                let data = new FormData();
                data.append('_token', "{{ csrf_token() }}");
                data.append('_method', "PUT");
                let a = function(){ window.location.href = '{{ route('qa.index') }}'; };
                let arr = [a];
                call_ajax_with_functions('','{{ route('qa.index') }}'+'/approve/'+this.value,data,arr);
            });
            //Reject Action
            $('.reject_action').click(function (e) {
                let data = new FormData();
                data.append('_token', "{{ csrf_token() }}");
                data.append('_method', "delete");
                let a = function(){ window.location.href = '{{ route('qa.index') }}'; };
                let arr = [a];
                call_ajax_with_functions('','{{ route('qa.index') }}'+'/'+this.value,data,arr);
            });
            //Reject Action
            $('.view_action').click(function (e) {
                call_ajax_modal('GET', '{{ route('qa.index') }}'+'/'+this.value, '', 'Product Details');
            });
        });
    </script>
@endsection
