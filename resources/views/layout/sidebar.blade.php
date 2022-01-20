<?php $role = Auth::user()->role->title ?>
<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  m-menu__item--{{ @request()->is('home') ? 'active' : '' }}" aria-haspopup="true">
                <a href="{{route('dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Dashboard
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            @if($role === 'Admin' || $role === 'Manager' || $role === 'Team Lead' || $role === 'Customer Services Representative')
                <li class="m-menu__item m-menu__item--submenu {{ @request()->is('lead_form') || @request()->is('lead_list') || @request()->is('recordings')  ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon fa fa-phone"></i>
                        <span class="m-menu__link-text">Call Dispositions</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item {{ @request()->is('lead_form') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('lead_form')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Form</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('lead_list') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('lead_list')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">List</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('recordings') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('recordings')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Call Queue</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($role === 'Admin' || $role === 'Manager' || $role === 'Team Lead' || $role === 'QA')
                <li class="m-menu__item m-menu__item--submenu {{ @request()->is('qa_list') || @request()->is('qa_form')  ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-interface-1"></i>
                        <span class="m-menu__link-text">Quality Assurance</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item {{ @request()->is('qa_form') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('qa_form')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Form</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('qa_list') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('qa_list')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            <li class="m-menu__item m-menu__item--submenu {{ @request()->is('leave_form') || @request()->is('leave_list')  ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:" class="m-menu__link m-menu__toggle">
                    <i class="fa fa-home m-menu__link-icon"></i>
                    <span class="m-menu__link-text">Leave Application</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ @request()->is('leave_form') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('leave_form')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet flaticon-interface-6">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Leave Form</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ @request()->is('leave_list') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('leave_list')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet flaticon-interface-6">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Leave List</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @if($role === 'Admin' || $role === 'Manager' || $role === 'Team Lead'|| $role === 'Customer Services Representative')
                <li class="m-menu__item m-menu__item--submenu {{ @request()->is('sales_transfer_form') || @request()->is('sales_transfer_list')  ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                        <i class="fa fa-exchange m-menu__link-icon"></i>
                        <span class="m-menu__link-text">Sales Transfer</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item {{ @request()->is('sales_transfer_form') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('sales_transfer_form')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Sales Transfer Form</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('sales_transfer_list') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('sales_transfer_list')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Sales Transfer List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($role === 'Admin' || $role === 'HR')
                <li class="m-menu__item  m-menu__item--{{ @request()->is('shift') ? 'active' : '' }}" aria-haspopup="true">
                    <a href="{{route('shift')}}" class="m-menu__link ">
                        <i class="m-menu__link-icon flaticon-cogwheel-1"></i>
                        <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                               Shifts
                            </span>
                        </span>
                    </span>
                    </a>
                </li>
            @endif
            @if($role === 'Admin' || $role === 'Manager' || $role === 'Team Lead')
                <li class="m-menu__item m-menu__item--submenu {{ @request()->is('attendance') ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                        </i>
                        <span class="m-menu__link-text">Attendance</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item {{ @request()->is('attendance')  ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('attendance')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet fa fa-check-circle" style="font-size:20px">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Mark Attendance</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($role === 'Admin' || $role === 'Manager')
                <li class="m-menu__item m-menu__item--submenu {{ @request()->is('team_create') || @request()->is('add_member_in_team/?') || @request()->is('team_list') ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-users"></i>
                        <span class="m-menu__link-text">Team Management</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item {{ @request()->is('team_create') ||  @request()->is('team_list') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('team_list')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Team</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($role === 'HR' || $role === 'Admin')
                <li class="m-menu__item  m-menu__item--{{ @request()->is('policies') ? 'active' : '' }}" aria-haspopup="true">
                    <a href="{{route('policies')}}" class="m-menu__link ">
                        <i class="m-menu__link-icon fa fa-file-powerpoint-o"></i>
                        <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Company Policies
                            </span>
                        </span>
                    </span>
                    </a>
                </li>
                <li class="m-menu__item  m-menu__item--{{ @request()->is('holiday') ? 'active' : '' }}" aria-haspopup="true">
                    <a href="{{route('holiday')}}" class="m-menu__link ">
                        <i class="m-menu__link-icon fa fa-calendar-times"></i>
                        <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Holidays
                            </span>
                        </span>
                    </span>
                    </a>
                </li>
            @endif
            @if($role === 'Admin' || $role === 'Manager' || $role === 'Team Lead')
                <li class="m-menu__item m-menu__item--submenu {{ @request()->is('lead_report')|| @request()->is('attendance_report_single') || @request()->is('attendance_report_monthly') || @request()->is('qa_report_form')  ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-graph"></i>
                        <span class="m-menu__link-text">Reports</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item {{ @request()->is('lead_report') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('lead_report')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Disposition Report</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('did_report') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('did_report')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">DID Report</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('qa_report_form') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('qa_report_form')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">QA Report</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('attendance_report_monthly') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('attendance_report_monthly')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Monthly Attendance</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('attendance_report_single') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('attendance_report_single')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Day Wise Attendance</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if($role === 'Admin')
                <li class="m-menu__item m-menu__item--submenu {{ @request()->is('users') || @request()->is('department') || @request()->is('roles_list')
  ||  @request()->is('lead_types_list') || @request()->is('lead_did_list') ? 'm-menu__item--open' : '' }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
                    <a href="javascript:" class="m-menu__link m-menu__toggle">
                        <i class="m-menu__link-icon flaticon-cogwheel-1"></i>
                        <span class="m-menu__link-text">Settings</span>
                        <i class="m-menu__ver-arrow la la-angle-right"></i>
                    </a>
                    <div class="m-menu__submenu ">
                        <span class="m-menu__arrow"></span>
                        <ul class="m-menu__subnav">
                            <li class="m-menu__item {{ @request()->is('roles_list')  ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('roles_list')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">User Roles</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('users') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('users')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Users</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('lead_types_list') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('lead_types_list')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Call Disposition Types</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('department')  ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('department')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-interface-6">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">Department</span>
                                </a>
                            </li>
                            <li class="m-menu__item {{ @request()->is('lead_did_list') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                                <a href="{{route('lead_did_list')}}" class="m-menu__link ">
                                    <i class="m-menu__link-bullet flaticon-list-1">
                                        <span></span>
                                    </i>
                                    <span class="m-menu__link-text">DID</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->
