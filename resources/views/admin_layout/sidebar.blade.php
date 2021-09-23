<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">
                <img alt="image" src="{{ asset('assets/img/logo.png') }}" class="header-logo" />
                <img class="logo-name" alt="image" src="{{ asset('assets/img/logo-text.png') }}" style="width: 150px" />
{{--                <span class="logo-name">Marcha Marlo</span>--}}
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="{{ @request()->is('home') ? 'active' : '' }}">
                <a href="{{route('dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ @request()->is('qa') ? 'active' : '' }}">
                <a href="{{route('users')}}" class="nav-link"><i data-feather="grid"></i><span>Users</span></a>
            </li>
            <li class="{{ @request()->is('categories') ? 'active' : '' }}">
                <a href="/categories" class="nav-link"><i data-feather="list"></i><span>Categories</span></a>
            </li>
            <li class="{{ @request()->is('qa_form') ? 'active' : '' }}">
                <a href="{{route('qa_form')}}" class="nav-link"><i data-feather="list"></i><span>Quality Assurance</span></a>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Settings</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('roles_list')}}">User Roles</a></li>
                    <li><a class="nav-link" href="widget-data.html">Data Widgets</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Apps</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="chat.html">Chat</a></li>
                    <li><a class="nav-link" href="portfolio.html">Portfolio</a></li>
                    <li><a class="nav-link" href="blog.html">Blog</a></li>
                    <li><a class="nav-link" href="calendar.html">Calendar</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Email</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="email-inbox.html">Inbox</a></li>
                    <li><a class="nav-link" href="email-compose.html">Compose</a></li>
                    <li><a class="nav-link" href="email-read.html">read</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
