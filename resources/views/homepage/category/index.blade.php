@extends('homepage.layouts.template')
@section('title')
    {{ @$category->name }}
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">{{ @$category->name }}</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">{{ @$category->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <div class="col-md-9">
                    @if (count(@$product) > 0)
                        <div class="row products products-big">
                            @foreach (@$product as $row)
                                <div class="col-lg-4 col-md-6">
                                    <div class="product">
                                        <div class="image"><a
                                                href="{{ route('product.detail', ['slug' => $row->slug]) }}"><img
                                                    src="{{ asset('data/product/' . $row->photo) }}" alt=""
                                                    class="img-fluid image1"></a></div>
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
                        <div class="pages">
                            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                                <ul class="pagination">
                                    {{ @$product->links() }}
                                </ul>
                            </nav>
                        </div>
                    @else
                        <p>Tidak ada produk untuk kategori ini</p>
                    @endif
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
