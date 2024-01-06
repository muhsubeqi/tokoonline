<footer class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h4 class="h6">Tentang kami</h4>
                @php
                    $slide1 = App\Models\Setting::where('setting', 'slide_1')->first();
                @endphp
                <p>
                    {{ @$slide1->tool3 }}
                </p>
                <hr>
                <hr class="d-block d-lg-none">
            </div>
            <div class="col-lg-4">
                <h4 class="h6">Produk</h4>
                <ul class="list-unstyled footer-blog-list">
                    @php
                        $products = App\Models\Product::limit(3)
                            ->orderBy('id', 'Desc')
                            ->get();
                    @endphp
                    @foreach ($products as $row)
                        <li class="d-flex align-items-center">
                            @if ($row->photo != null)
                                <div class="image"><img src="{{ asset('data/product/' . $row->photo) }}" alt="No Photo"
                                        class="img-fluid"></div>
                            @else
                                <div class="image"><img src="{{ asset('homepage/img/no-image.png') }}" alt="No Photo"
                                        class="img-fluid"></div>
                            @endif
                            <div class="text">
                                <h5 class="mb-0"> <a href="post.html">{{ $row->name }}</a></h5>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <hr class="d-block d-lg-none">
            </div>
            <div class="col-lg-4">
                @php
                    $storeAddress = App\Models\Setting::where('setting', 'store_address')->first();
                    $storePhone = App\Models\Setting::where('setting', 'store_phone')->first();
                    $storeEmail = App\Models\Setting::where('setting', 'store_email')->first();
                @endphp
                <h4 class="h6">Kontak</h4>
                <p class="text-uppercase">
                    <strong>{{ $storeAddress->tool2 }}</strong><br>{{ $storePhone->tool1 }}<br>{{ $storeEmail->tool1 }}
                </p>
                <hr class="d-block d-lg-none">
            </div>
        </div>
    </div>
    <div class="copyrights">
        <div class="container">
            <div class="row">
                @php
                    $storeName = App\Models\Setting::where('setting', 'store_name')->first();
                @endphp
                <div class="col-lg-4 text-center-md">
                    <p>&copy; {{ date('Y') }} {{ $storeName->tool1 }}</p>
                </div>
                <div class="col-lg-8 text-right text-center-md">
                    <p>Sistem created by <a href="https://id.linkedin.com/in/muhammadsubeqi">m.subeqi</a></p>
                    <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
            </div>
        </div>
    </div>
</footer>
