@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Menus</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                @foreach ($menus as $index => $menu)
                    <li class="m-menu__item m-menu__item--submenu {{ @request()->is('lead_form') || @request()->is('lead_list')  ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        @if(count($menu->children) == 0)
                            <a href="{{route($menu->url)}}" class="m-menu__link m-menu__toggle">
                                @else
                                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                                        @endif
                                        <i class="m-menu__link-icon {{$menu->icon}}"></i>
                                        <span class="m-menu__link-text">{{$menu->title}}</span>
                                        <i class="m-menu__ver-arrow la la-angle-right "></i>
                                    </a>
                                    @if(count($menu->children) != 0)
                                        <div class="m-menu__submenu ">
                                            @foreach($menu->children as $indx => $child)
                                                <span class="m-menu__arrow"></span>
                                                <ul class="m-menu__subnav">
                                                    <li class="m-menu__item {{ @request()->is($child->url) ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                                        <a href="{{route($child->url)}}" class="m-menu__link ">
                                                            <i class="m-menu__link-bullet {{$child->icon}}">
                                                                <span></span>
                                                            </i>
                                                            <span class="m-menu__link-text">{{$child->title}}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </div>
                                    @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
@section('footer_scripts')
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
