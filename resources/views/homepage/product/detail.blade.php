@extends('homepage.layouts.template')
@section('title')
    Produk
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">{{ $product->name }}</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Detail Produk</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <!-- LEFT COLUMN _________________________________________________________-->
                <div class="col-lg-9">
                    <p class="goToDescription"><a href="#details" class="scroll-to text-uppercase">Scroll untuk melihat
                            deskripsi produk</a></p>
                    <div id="productMain" class="row">
                        <div class="col-sm-6">
                            <div data-slider-id="1" class="owl-carousel shop-detail-carousel">
                                <div> <img src="{{ asset('data/product/' . $product->photo) }}" alt=""
                                        class="img-fluid"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <form method="get" action="{{ route('cart') }}">
                                @csrf
                                <p class="price">Rp. {{ number_format($product->price, 0, '', '.') }}</p>
                                <p class="text-center" style="font-size: 20px">Weight : {{ $product->weight }} Gram</p>
                                <p class="text-center" style="font-size: 20px">Stock : {{ $product->stock }}</p>
                                @php
                                    $cart = Cart::content()
                                        ->where('id', $product->id)
                                        ->first();
                                    $stock = $product->stock - @$cart->qty;
                                @endphp
                                @if ($stock >= 0)
                                    <p class="text-center" style="font-size: 20px">Pilih Jumlah Order :</p>
                                    <div class="mt-2 d-flex justify-content-center align-items-center">
                                        <select class="form-control" name="qty" style="width: 20%">
                                            @for ($i = 1; $i <= $stock; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <br>
                                    <p class="text-center">
                                        @if (Auth::user())
                                            <button type="submit" id="form-submit" class="btn btn-template-outlined"><i
                                                    class="fa fa-shopping-cart"></i> Add to cart</button>
                                        @else
                                            <small>Login dahulu untuk melakukan transaksi</small>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-center">
                                        <span class="btn btn-secondary">Produk Habis
                                        </span>
                                    </p>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div id="details" class="box mb-4 mt-4">
                        <p></p>
                        <h4>Penjual</h4>
                        <p>{!! $product->user->name !!}</p>
                        <h4>Detail Produk</h4>
                        <p>{!! $product->description !!}</p>
                    </div>
                    <div id="product-social" class="box social text-center mb-5 mt-5">
                        <h4 class="heading-light">Share ke teman temanmu</h4>
                        <ul class="social list-inline">
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse"
                                    class="external facebook"><i class="fa fa-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse"
                                    class="external gplus"><i class="fa fa-google-plus"></i></a></li>
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse"
                                    class="external twitter"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="#" data-animate-hover="pulse" class="email"><i
                                        class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-3">
                    <!-- MENUS AND FILTERS-->
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Kategori</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm category-menu">
                                @foreach ($categories as $category)
                                    @php
                                        $count = App\Models\Category::where('parent_id', $category->id)->count();
                                    @endphp
                                    <li class="nav-item"><a href="{{ route('category', ['slug' => $category->slug]) }}"
                                            class="nav-link d-flex align-items-center justify-content-between"><span>{{ $category->name }}
                                            </span><span class="badge badge-secondary">{{ $count }}</span></a>
                                        <ul class="nav nav-pills flex-column">
                                            @foreach ($category->children as $subCategory)
                                                <li class="nav-item"><a
                                                        href="{{ route('category', ['slug' => $subCategory->slug]) }}"
                                                        class="nav-link">{{ $subCategory->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @php
                        $advertisement = App\Models\Setting::where('setting', 'advertisement')->first();
                    @endphp
                    @if (@$advertisement->tool1 != null)
                        <div class="banner"><a href="{{ @$advertisement->tool2 }}"><img
                                    src="{{ asset('/data/setting/' . @$advertisement->tool1) }}" alt="Iklan"
                                    class="img-fluid"></a></div>
                    @else
                        <div class="banner"><a href="#"><img src="" alt="Iklan" class="img-fluid"></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
