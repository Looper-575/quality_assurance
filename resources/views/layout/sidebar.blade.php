<?php $role = Auth::user()->role->role_id;
$menus = get_parent_menus($role);
?>
<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow ">
            @foreach ($menus as $index => $menu)
                @if(has_permission_from_db($role, $menu->id, 'view') == 1)
                    <?php $childs = get_child_menus($menu->id); $open_parent = 0; ?>
                    @foreach($childs as $child)
                        @if($child->url == @request()->route()->getName())
                            <?php $open_parent = 1;
                            break;
                            ?>
                        @else
                            <?php $open_parent = 0;
                            ?>
                        @endif
                    @endforeach
                    <li class="m-menu__item m-menu__item--submenu {{ (@request()->route()->getName() == $menu->url) || $open_parent == 1 ? 'm-menu__item--active m-menu__item--open active' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                        @if(count($menu->children) == 0)
                            <a href="{{route($menu->url)}}" class="m-menu__link {{count($menu->children) == 0 ? '' : 'm-menu__toggle' }}">
                                @else
                                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                                        @endif
                                        <i class="m-menu__link-icon {{$menu->icon}}"></i>
                                        <span class="m-menu__link-text">{{$menu->title}}</span>
                                        @if(count($menu->children) != 0)
                                            <i class="m-menu__ver-arrow la la-angle-right "></i>
                                        @endif
                                    </a>
                                    <div class="m-menu__submenu">
                                        <span class="m-menu__arrow"></span>
                                        <ul class="m-menu__subnav">
                                            <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                                                    <span class="m-menu__link">
                                                        <span class="m-menu__link-text"> {{$menu->title}} </span>
                                                    </span>
                                            </li>
                                            @if(count($menu->children) != 0)
                                                @foreach($childs as $indx => $child)
                                                    @if(has_permission_from_db($role, $child->id, 'view') == 1)
                                                        <li class="m-menu__item {{ @request()->is($child->url) ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                                            <a href="{{route($child->url)}}" class="m-menu__link ">
                                                                <i class="m-menu__link-bullet {{$child->icon}}">
                                                                    <span></span>
                                                                </i>
                                                                <span class="m-menu__link-text">{{$child->title}} </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                        </ul>
                                        @endif
                                    </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
