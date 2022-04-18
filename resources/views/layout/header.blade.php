<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item    m-header "  m-minimize-offset="200" m-minimize-mobile-offset="200" >
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="{{route('dashboard')}}" class="m-brand__logo-wrapper">
                            <img alt="" src="{{asset('assets/img/logo-full.png')}}" width="150"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>
                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
                                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                    <span class="m-nav__link-icon"><i class="flaticon-music-2"></i></span>
                                </a>
                                @include('notifications.notifications')
                            </li>
                            <?php $user = Auth::user(); ?>
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic">
                                        <img style="width: 41px; height: 41px; object-fit: cover;" src="{{(isset(Auth::user()->image) && !empty(Auth::user()->image))?asset('user_images/'.Auth::user()->image):asset('user_images/user.png')}}" class="m--img-rounded m--marginless m--img-centered" alt="{{Auth::user()->full_name}}"/>
                                    </span>
                                    <span class="m-topbar__username m--hide">
                                        {{Auth::user()->full_name}}
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center" style="background: url({{asset('assets/app/media/img/misc/user_profile_bg.jpg')}}); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark position-relative">
                                                <div class="m-card-user__pic">
                                                    <img style="width: 70px; height: 70px; object-fit: cover;" src="{{(isset(Auth::user()->image) && !empty(Auth::user()->image))?asset('user_images/'.Auth::user()->image):asset('user_images/user.png')}}" class="m--img-rounded m--marginless m--img-centered" alt="{{Auth::user()->full_name}}"/>
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">
                                                        {{$user->full_name}}
                                                    </span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                        {{$user->email}}
                                                    </a>
                                                </div>
                                                @php $employee_id = get_employee_id(Auth::user()->user_id) @endphp
                                                @if(Auth::user()->user_type == 'Employee')
                                                    @if($employee_id != 0)
                                                        <div class="m-card-user__edit position-absolute">
                                                            <a href="{{route('employee_data_view',['employee_id' => $employee_id])}}" id="{{$employee_id}}" class="btn btn-info">
                                                                <i class="la la-edit"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="m-card-user__edit position-absolute">
                                                            <a href="{{route('employee_form')}}" id="{{$employee_id}}" class="btn btn-info">
                                                                <i class="la la-edit"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">Section</span>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__item">
                                                        <button type="button" class="btn m-btn--pill btn-info m-btn m-btn--label-brand m-btn--bolder" data-toggle="modal" data-target="#change_password" value="{{Auth::user()->user_id}}">
                                                            Change Password
                                                        </button>
                                                        <a href="{{route('logout')}}" class="float-right btn m-btn--pill btn-danger m-btn m-btn--label-brand m-btn--bolder">
                                                            Logout
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="m_quick_sidebar_toggle" class="m-nav__item">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>
                                </a>
                            </li>
                            {{--                            <li id="chat_sidebar_toggler" class="m-nav__item">--}}
                            {{--                                <a href="javascript:toggle_chat();" class="m-nav__link m-dropdown__toggle">--}}
                            {{--                                    <span class="m-nav__link-icon"><i class="flaticon-chat-1"></i></span>--}}
                            {{--                                </a>--}}
                            {{--                            </li>--}}
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
<!-- END: Header -->
<!--begin::Modal-->
<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="change_passwordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="change_passwordLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="change_pass" action="javascript:change_password();" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" id="c_user_id" value="{{Auth::user()->user_id}}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>New Password</label>
                                <input id="password" name="password" class="form-control" type="password" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                                <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3"><b>Please Enter Your Password below to confirm and save changes</b></div>
                        <div class="col">
                            <div class="form-group">
                                <label>Current Password</label>
                                <input id="curr_password" name="curr_password"  class="form-control" type="password" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
<script>
    function change_password() {
        let data = new FormData($('#change_pass')[0]);
        let a = function(){
            $('#change_password').modal('hide');
        };
        let arr = [a];
        call_ajax_with_functions('','{{route('change_pass')}}',data,arr);
    }
</script>
