<header class="nav-holder make-sticky">
    <div id="navbar" role="navigation" class="navbar navbar-expand-lg">
        <div class="container">
            @php
                $logo = App\Models\Setting::where('setting', 'store_logo')->first();
                $nama = App\Models\Setting::where('setting', 'store_name')->first();
            @endphp
            <a href="{{ route('home') }}" class="navbar-brand home">
                @if (@$logo->tool1 != null)
                    <img src="{{ asset('data/setting/' . @$logo->tool1) }}" width="50" alt="Universal logo"
                        class="d-none d-md-inline-block" style="border-radius:50%;">
                @else
                    <img src="" width="50" alt="Universal logo" class="d-none d-md-inline-block"
                        style="border-radius:50%;">
                @endif
                <span class="mx-3 fw-bold"> {{ @$nama->tool1 }}</span>
            </a>
            <button type="button" data-toggle="collapse" data-target="#navigation"
                class="navbar-toggler btn-template-outlined"><span class="sr-only">Toggle navigation</span><i
                    class="fa fa-align-justify"></i></button>
            <div id="navigation" class="navbar-collapse collapse">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a
                            href="{{ route('home') }}">Home <b class="caret"></b></a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('product') ? 'active' : '' }}"><a
                            href="{{ route('product') }}">Produk <b class="caret"></b></a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('member') ? 'active' : '' }}"><a
                            href="{{ route('member') }}">Member <b class="caret"></b></a>
                    </li>
                    <li class="nav-item dropdown menu-large {{ request()->routeIs('category*') ? 'active' : '' }}"><a
                            href="#" data-toggle="dropdown" class="dropdown-toggle">Kategori<b
                                class="caret"></b></a>
                        <ul class="dropdown-menu megamenu">
                            <li>
                                <div class="row">
                                    @php
                                        $categories = \App\Models\Category::where('parent_id', null)->get();
                                    @endphp
                                    @foreach ($categories as $category)
                                        <div class="col-md-6 col-lg-3">
                                            <h5>{{ $category->name }}</h5>
                                            <ul class="list-unstyled mb-3">
                                                @foreach ($category->children as $subCategory)
                                                    <li class="nav-item"><a
                                                            href="{{ route('category', ['slug' => $subCategory->slug]) }}"
                                                            class="nav-link">
                                                            {{ $subCategory->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- ========== Profil dropdown ==================-->
                    @auth
                        <li class="nav-item dropdown"><a href="javascript: void(0)" data-toggle="dropdown"
                                class="dropdown-toggle">{{ Auth::user()->username }} <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                @if (auth()->user()->role == 'admin')
                                    <li class="dropdown-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">
                                            Dashboard</a></li>
                                @else
                                    <li class="dropdown-item"><a href="{{ route('cart.detail') }}" class="nav-link"><i
                                                class="fa fa-shopping-cart"></i> Keranjang ({{ Cart::count() }})</a></li>
                                    <li class="dropdown-item"><a href="{{ route('cart.myorder') }}" class="nav-link"><i
                                                class="fa fa-list-alt"></i> Order</a></li>
                                    <li class="dropdown-item"><a href="{{ route('myaccount') }}" class="nav-link"><i
                                                class="fa fa-user"></i> Profil</a></li>
                                @endif
                                <li class="dropdown-item"><a href="{{ route('logout.supplier-member') }}"
                                        class="nav-link"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="{{ route('cart.detail') }}">({{ Cart::count() }})<i
                                    class="fa fa-shopping-cart"></i><b class="caret"></b></a>
                        </li>
                    @endauth
                    <!-- ========== Contact dropdown end ==================-->
                </ul>
            </div>
            <div id="search" class="collapse clearfix">
                <form role="search" class="navbar-form">
                    <div class="input-group">
                        <input type="text" placeholder="Search" class="form-control"><span class="input-group-btn">
                            <button type="submit" class="btn btn-template-main"><i
                                    class="fa fa-search"></i></button></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
