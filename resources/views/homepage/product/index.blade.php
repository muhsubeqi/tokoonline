@extends('homepage.layouts.template')
@section('title')
    Produk
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Semua Produk</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Produk</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
                                        <p class="price">{{ $row->price }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pages">
                        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                            <ul class="pagination">
                                {!! $product->links() !!}
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 banner mb-small"><a href="#"><img src="img/banner2.jpg" alt=""
                                    class="img-fluid"></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
