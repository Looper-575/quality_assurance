@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div id="form_row" class="row" style="display: {{ isset($category_edit) ? '' : 'none' }}">
        <div class="col-12">
            <form method="post" id="category_form">
                @csrf
                @if (isset($category_edit))
                    @method('put')
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>HTML5 Form Basic</h4>
                    </div>
                    <div class="card-body" id="add_more_cats_data">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input name="title[]" required type="text" class="form-control cat_title"
                                           value="{{ isset($category_edit) ? $category_edit->title : '' }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input name="slug[]" type="text" required readonly class="form-control cat_slug"
                                           value="{{ isset($category_edit) ? $category_edit->slug : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-warning mr-1" id="add_more_cats_action" type="button">Add More</button>
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-secondary" id="cancel_action" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="justify-content: space-between;">
                    <h4>Categories List</h4>
                    @if (!isset($category_edit))
                        <button id="add_action" class="btn btn-icon icon-left btn-primary"> <i class="fas fa-plus"></i> Add new</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="datatable">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Added On</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ parse_datetime_get($category->added_on) }}</td>
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>
                                        @if($category->status===1)
                                            <div class="badge badge-success badge-shadow">Approved</div>
                                        @else
                                            <div class="badge badge-warning badge-shadow">Unapproved</div>
                                         @endif
                                    </td>
                                    <td>
                                        <a id="edit_action" href="{{ route('categories.edit', $category->category_id) }}" class="btn btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                        @if ($category->status === 2)
                                            <button class="btn btn-success approve_action" title="Approve" value="{{ $category->category_id }}"><i class="fas fa-check"></i></button>
                                        @endif
                                        <button class="btn btn-danger delete_action" value="{{ $category->category_id }}" title="Delete"><i class="fas fa-trash"></i></button>
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
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script>
        $( document ).ready(function() {
            //form submission;
            $('#category_form').submit(function (e) {
                e.preventDefault();
                let data = new FormData(this);
                let a = function(){ window.location.href = '{{ route('categories.index') }}'; };
                let arr = [a];
                call_ajax_with_functions('','{{ isset($category_edit) ? route('categories.update', $category_edit->category_id) : route('categories.store') }}',data,arr);
            });
            // slug generation
            $('.cat_title').keyup(function (e){
                let slug = e.currentTarget.value.toLowerCase().replace(' ', '-');
                $(e.currentTarget).closest('.row').find('.cat_slug').val(slug);
            });
            // show form
            $('#add_action').click(function (){
                $('#form_row').fadeIn('slow', function (){
                    $('#form_row').scrollTop();
                });
            });
            // Cancel action
            $('#cancel_action').click(function (){
                window.location.href="{{route('categories.index')}}";
            });
            // Cancel action
            $('.approve_action').click(function (){
                let data = new FormData();
                data.append('_token', "{{ csrf_token() }}");
                data.append('_method', "PUT");
                let a = function(){ window.location.href = '{{ route('categories.index') }}'; };
                let arr = [a];
                call_ajax_with_functions('','{{ route('categories.index') }}'+'/approve/'+this.value,data,arr);
            });
            //delete
            $('.delete_action').click(function (e) {
                let data = new FormData();
                data.append('_token', "{{ csrf_token() }}");
                data.append('_method', "delete");
                let a = function(){ window.location.href = '{{ route('categories.index') }}'; };
                let arr = [a];
                call_ajax_with_functions('','{{ route('categories.index') }}'+'/'+this.value,data,arr);
            });
        });
        //more cat fields
        let cat = (function () {/*
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input name="title[]" required type="text" class="form-control cat_title">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Slug</label>
                        <input name="slug[]" required type="text" readonly class="form-control cat_slug">
                    </div>
                </div>
            </div>
        */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        // add more category fields
        $('#add_more_cats_action').click(function (){
            $('#add_more_cats_data').append(cat);
        });
    </script>
@endsection
