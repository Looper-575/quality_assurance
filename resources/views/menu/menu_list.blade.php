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
                    <h3 class="m-portlet__head-text">Sidebar Menus</h3>
                </div>
                @if($has_permissions->add == 1)
                    <div class="float-right mt-3">
                        <div class="m-portlet__head-tools float-right">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a id="add_new_btn" href="javascript:;" class="nav-link m-tabs__link">
                                        <span class="add-new-button"><i class="la la-plus"></i><span>Add New</span></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" id="html_table">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Parent</th>
                    <th>Sort Order</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($menus as $index => $menu)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td><i class="m-menu__link-icon fa {{$menu->icon}} px-2"></i>{{$menu->title}}</td>
                        <td>{{$menu->url}}</td>
                        <td>{{@$menu->parent->title}}</td>
                        <td>{{@$menu->sort_order}}</td>
                        <td>
                            @if($has_permissions->update == 1)
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary edit_btn" title="Edit Menu" value="{{json_encode($menu)}}"><i class="fa fa-edit"></i></button>
                                    @if(count($menu->children) == 0)
                                    <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$menu->id}}"><i class="fa fa-trash"></i></button>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                    @if($menu->children !== null)
                        @foreach($menu->children as $indx => $child)
                            <tr>
                                <td>{{$index+1}}.{{$indx+1}}</td>
                                <td><i class="m-menu__link-icon fa {{$child->icon}} px-2"></i>{{$child->title}}</td>
                                <td>{{$child->url}}</td>
                                <td>{{@$child->parent->title}}</td>
                                <td>{{@$child->sort_order}}</td>
                                <td>
                                    @if(count($child->children) == 0)
                                        @if($has_permissions->add == 1)
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-primary edit_btn" title="Edit Menu" value="{{json_encode($child)}}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$child->id}}"><i class="fa fa-trash"></i></button>
                                        </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="add_new_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="add_new_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Add Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="add_menu_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="title_id">Title </label>
                                    <input class="form-control" type="text" name="title" value="" id="title_id" placeholder="Enter Title.." required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="url_id">URL </label>
                                    <input class="form-control" type="text" name="url" value="" id="url_id" placeholder="Enter Route Name .." required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="icon_id">Icon </label>
                                    <input class="form-control" type="text" name="icon" value="" id="icon_id" placeholder="Enter Icons Class .." required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="parent_id">Parent Menu</label>
                                    <select class="form-control select2" name="parent_id" id="parent_id" required>
                                        <option value="">Select Menu</option>
                                            <option value="0">Make Parent </option>
                                        @foreach($menus as $menu)
                                            <option value="{{$menu->id}}">{{$menu->title}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="sort_order">Sort Order </label>
                                    <input class="form-control" type="number" step="0.01" name="sort_order" value="" min="0" id="sort_order" placeholder="" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input class="form-control" type="hidden" name="menu_id" value="" id="menu_id">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('id', id);
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
                    call_ajax('', '{{route('menu_delete')}}', data);
                }
            })
        });

        $('#add_new_btn').click(function () {
            $('#add_new_modal').modal('toggle');
        });

        $('#add_menu_form').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('add_menu_form');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('save_side_menu')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#menu_id').val(data.id);
            $('#title_id').val(data.title);
            $('#url_id').val(data.url);
            $('#icon_id').val(data.icon);
            $('#parent_id').val(data.parent_id);
            $('#sort_order').val(data.sort_order);
            $('#add_new_modal').modal('toggle');
        });
    </script>
@endsection
