<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 ">
    <!-- Brand Logo -->
    @php
        $logo = App\Models\Setting::where('setting', 'store_logo')->first();
        $nama = App\Models\Setting::where('setting', 'store_name')->first();
    @endphp
    <a href="index3.html" class="brand-link">
        @if ($logo->tool1 != null)
            <img src="{{ asset('/data/setting/' . $logo->tool1) }}" alt="Logo" class="brand-image img-circle "
                style="opacity: .8">
        @else
            <img src="" alt="Logo" class="brand-image img-circle " style="opacity: .8">
        @endif
        <span class="brand-text font-weight-light"><strong>{{ @$nama->tool1 }}</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @if (auth()->user()->image != null)
                <div class="image">
                    <img src="{{ asset('/data/user/' . auth()->user()->image) }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                </div>
            @else
                <div class="image">
                    <img src="{{ asset('/admin/dist/img/avatar5.png') }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                </div>
            @endif

            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-collapse-hide-child nav-child-indent flex-column"
                data-widget="treeview" role="menu" data-accordion="false" id="list-sidebar">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt bkg-blue"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                {{-- Setting --}}
                <li class="nav-item">
                    <a href="{{ route('admin.setting') }}"
                        class="nav-link {{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog bkg-grey"></i>
                        <p>
                            Setting
                        </p>
                    </a>
                </li>

                <li class="nav-header">Master Data</li>

                <li class="nav-item">
                    <a href="{{ route('admin.category') }}"
                        class="nav-link {{ request()->routeIs('admin.category*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes bkg-purple"></i>
                        <p>Kategori</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.product') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.product') }}"
                        class="nav-link {{ request()->routeIs('admin.product*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-laptop bkg-green"></i>
                        <p>Produk</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.user') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.user') }}"
                        class="nav-link {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users bkg-blue-2"></i>
                        <p>User</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.media') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.media') }}"
                        class="nav-link {{ request()->routeIs('admin.media*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file bkg-red"></i>
                        <p>File Manager</p>
                    </a>
                </li>

                <li class="nav-header">Transaksi</li>

                <li class="nav-item {{ request()->routeIs('admin.transaction') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.transaction') }}"
                        class="nav-link {{ request()->routeIs('admin.transaction*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart bkg-yellow"></i>
                        <p>Transaksi</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.report') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.report') }}"
                        class="nav-link {{ request()->routeIs('admin.report*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-download bkg-green"></i>
                        <p>Laporan</p>
                    </a>
                </li>

                <li class="nav-header">Raja Ongkir</li>
                <li
                    class="nav-item {{ request()->routeIs('admin.province*') ? 'menu-open' : '' }} 
                    {{ request()->routeIs('admin.city*') ? 'menu-open' : '' }}
                    {{ request()->routeIs('admin.cost*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.province') ? 'active' : '' }}
                         {{ request()->routeIs('admin.city') ? 'active' : '' }}
                         {{ request()->routeIs('admin.cost') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list-alt bkg-grey"></i>
                        <p>
                            Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.province') }}"
                                class="nav-link {{ request()->routeIs('admin.province') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Provinsi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.city') }}"
                                class="nav-link {{ request()->routeIs('admin.city') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kota</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.cost') }}"
                                class="nav-link {{ request()->routeIs('admin.cost') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hitung Ongkir</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Profil</li>

                {{-- Profile --}}
                <li class="nav-item">
                    <a href="{{ route('admin.profile') }}"
                        class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user bkg-blue"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
