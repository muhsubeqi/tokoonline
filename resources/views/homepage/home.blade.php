@extends('homepage.layouts.template')
@section('title')
    Home
@endsection
@section('content')
    @php
        $banner = App\Models\Setting::where('setting', 'banner_home')->first();
        $slide1 = App\Models\Setting::where('setting', 'slide_1')->first();
        $slide2 = App\Models\Setting::where('setting', 'slide_2')->first();
    @endphp
    <section style="background: url('/data/setting/{{ @$banner->tool1 }}') center center repeat; background-size: cover;"
        class="relative-positioned">
        <!-- Carousel Start-->
        <div class="home-carousel">
            <div class="dark-mask mask-primary"></div>
            <div class="container">
                <div class="homepage owl-carousel">
                    <div class="item">
                        <div class="row align-items-center">
                            <div class="col-md-7 text-center"><img src="{{ asset('data/setting/' . @$slide1->tool1) }}"
                                    style="width: 70%" alt="" class="img-fluid"></div>
                            <div class="col-md-5">
                                <h2>{{ @$slide1->tool2 }}</h2>
                                <p>{{ @$slide1->tool3 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row align-items-center">
                            <div class="col-md-5 text-right">
                                <h1>{{ @$slide2->tool2 }}</h1>
                                <p>{{ @$slide2->tool3 }}</p>
                            </div>
                            <div class="col-md-7"><img src="{{ asset('data/setting/' . @$slide2->tool1) }}"
                                    style="width: 70%" alt="" class="img-fluid"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End-->
    </section>
    <section class="bar no-mb">
        <div data-animate="fadeInUp" class="container">
            <div id="content">
                <div class="container">
                    <div class="row bar">
                        <div class="col-md-12">
                            <div class="row products products-big">
                                @foreach ($product as $row)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product">
                                            @if ($row->photo != null)
                                                <div class="image"><a
                                                        href="{{ route('product.detail', ['slug' => $row->slug]) }}"><img
                                                            src="{{ asset('data/product/' . $row->photo) }}" alt=""
                                                            class="img-fluid image1"></a></div>
                                            @else
                                                <div class="image"><a
                                                        href="{{ route('product.detail', ['slug' => $row->slug]) }}"><img
                                                            src="{{ asset('homepage/img/no-image.png') }}" alt=""
                                                            class="img-fluid image1"></a></div>
                                            @endif
                                            <div class="text">
                                                <h3 class="h5"><a
                                                        href="{{ route('product.detail', ['slug' => $row->slug]) }}">{{ $row->name }}</a>
                                                </h3>
                                                <p class="price">Rp. {{ number_format($row->price, 0, '', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- GET IT-->
    <div class="get-it">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 text-center p-3">
                    <h3>Lihat Semua Produk Kami?</h3>
                </div>
                <div class="col-lg-4 text-center p-3"> <a href="{{ route('product') }}"
                        class="btn btn-template-outlined-white">Lanjutkan</a></div>
            </div>
        </div>
    </div>
@endsection
