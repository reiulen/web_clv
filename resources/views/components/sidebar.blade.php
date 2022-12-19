<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center" style="gap: 7px">
        <img src="{{ asset('assets/images/logo_clv.png') }}" alt=" Logo"
            style="height: 40px; width: 40px; object-fit: cover" />
        <div class="brand-text h4">CLV Premium</div>
    </a>

    <!-- Sidebar -->
    <div
        class="sidebar os-host os-theme-light os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pt-2 pb-2 mb-3 d-flex align-items-start" style="gap: 5px;">
            <div class="image">
                <img src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-2"
                    style="width: 40px; height: 40px; object-fit: cover;" alt="User Image" />
            </div>
            <div class="dropdown">
                <a class="user-nama" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <p>
                        {{ Str::substr(Auth::user()->name, 0, 18) }}
                    </p>
                    <p class="level text-muted">
                        Admin
                    </p>
                </a>
                <div class="dropdown-menu bg-dark border-0 shadow-lg" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ url('/user/profile') }}"><i
                            class="fa fa-user text-primary pr-1"></i> Profil</a>
                    @can('ubahpassword')
                        <a class="dropdown-item" href="#"><i class="fa fa-lock text-success pr-1"></i> Ubah
                            Password</a>
                    @endcan
                    <div class="dropdown-divider"></div>
                    <a role="button" class="dropdown-item logout" data-nama=""><i
                            class="fa fa-sign-out-alt text-danger pr-1"></i> Keluar</a>

                    <form id="logoutForm" method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search..."
                    aria-label="Search" />
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-header">MENU UTAMA</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ set_active(['dashboard']) }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li
                    class="nav-item nav-item {{ set_menu_open(['blog.artikel.index']) }}">
                    <a href="#" class="nav-link {{ set_active(['blog.artikel.index']) }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>
                            {{ __('Blog') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('blog.artikel.index') }}" class="nav-link {{ set_active_sub(['blog.artikel.index']) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Artikel') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item nav-item {{ set_menu_open(['page.type_page.index']) }}">
                    <a href="#" class="nav-link {{ set_active(['page.type_page.index']) }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>
                            {{ __('Halaman') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('page.type_page.index') }}" class="nav-link {{ set_active_sub(['page.type_page.index']) }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Tipe Halaman') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
