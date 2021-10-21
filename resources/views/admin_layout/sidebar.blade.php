<?php $role = Auth::user()->role->title ?>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">
                <img alt="image" src="{{ asset('assets/img/logo.png') }}" class="header-logo" />
                <img class="logo-name" alt="image" src="{{ asset('assets/img/logo-text.png') }}" style="width: 90px" />
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="{{ @request()->is('home') ? 'active' : '' }}">
                <a href="{{route('dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @if($role === 'Admin' || $role === 'Manager' || $role === 'Supervisor' || $role === 'Customer Services Representative')
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown {{ @request()->is('lead_form') || @request()->is('lead_list')  ? 'toggled' : '' }}"><i data-feather="briefcase"></i><span>Call Disposition</span></a>
                    <ul class="dropdown-menu" style="display:  {{ @request()->is('lead_form') || @request()->is('lead_list')  ? 'block' : 'none' }}">
                        <li class="{{ @request()->is('lead_form') ? 'active' : '' }}">
                            <a href="{{route('lead_form')}}" class="nav-link"><i data-feather="list"></i><span>Form</span></a>
                        </li>
                        <li class="{{ @request()->is('lead_list') ? 'active' : '' }}">
                            <a href="{{route('lead_list')}}" class="nav-link"><i data-feather="list"></i><span>List</span></a>
                        </li>
                    </ul>
                </li>
            @endif
            @if($role === 'Admin' || $role === 'Manager' || $role === 'Supervisor' || $role === 'QA')
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown {{ @request()->is('qa_form') || @request()->is('qa_list')  ? 'toggled' : '' }}"><i data-feather="briefcase"></i><span>Quality Assurance</span></a>
                    <ul class="dropdown-menu" style="display:  {{ @request()->is('qa_form') || @request()->is('qa_list')  ? 'block' : 'none' }}">
                        <li class="{{ @request()->is('qa_form') ? 'active' : '' }}">
                            <a href="{{route('qa_form')}}" class="nav-link"><i data-feather="list"></i><span>Form</span></a>
                        </li>
                        <li class="{{ @request()->is('qa_list') ? 'active' : '' }}">
                            <a href="{{route('qa_list')}}" class="nav-link"><i data-feather="list"></i><span>List</span></a>
                        </li>
                    </ul>
                </li>
            @endif
            @if($role === 'Admin')
                <li class="dropdown {{ @request()->is('users') || @request()->is('roles_list') ? 'active' : '' }}">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Settings</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ @request()->is('roles_list') ? 'active' : '' }}">
                            <a href="{{route('roles_list')}}" class="nav-link"><i data-feather="list"></i><span>User Roles</span></a></li>
                        <li class="{{ @request()->is('users') ? 'active' : '' }}">
                            <a href="{{route('users')}}" class="nav-link"><i data-feather="users"></i><span>Users</span></a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </aside>
</div>
