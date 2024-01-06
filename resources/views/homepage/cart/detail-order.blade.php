@extends('homepage.layouts.template')
@section('title')
    My Order
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">My Orders</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">My Orders</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <div id="customer-order" class="col-lg-12">
                    @php
                        $storePhone = App\Models\Setting::where('setting', 'store_phone')->first();
                        $phone = substr($storePhone->tool1, 1);
                    @endphp
                    <p class="lead text-muted">Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami, pusat
                        layanan pelanggan kami bekerja untuk Anda 24 jam.
                        <a href="https://wa.me/62{{ @$phone }}" class="btn btn-success" target="_blank"><i
                                class="fa fa-whatsapp">
                                WhatsApp</i></a>
                    </p>
                    <p class="lead">
                        Pesanan dengan Invoice
                        <strong>{{ $transaction[0]->code }}</strong>
                        pada
                        <strong>{{ date('d/m/Y H:i', strtotime($transaction[0]->created_at)) }}</strong>
                    </p>
                    <div class="box">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="border-top-0">Product</th>
                                        <th class="border-top-0">Jumlah</th>
                                        <th class="border-top-0">Berat</th>
                                        <th class="border-top-0">Harga</th>
                                        <th class="border-top-0">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction as $row)
                                        <tr>
                                            <td><a href="#"><img
                                                        src="{{ asset('data/product/' . $row->product->photo) }}"
                                                        alt="{{ $row->product->name }}" class="img-fluid"></a></td>
                                            <td><a href="#">{{ $row->product->name }}</a></td>
                                            <td>{{ $row->qty }}</td>
                                            <td>{{ $row->product->weight }}</td>
                                            <td>{{ $row->product->price }}</td>
                                            <td>{{ $row->qty * $row->product->price }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    @php
                                        $subtotal = $transaction->sum('subtotal');
                                        $ongkir = $transaction[0]->ekspedisi['value'];
                                        $total = $transaction->sum('subtotal') + $transaction[0]->ekspedisi['value'];
                                    @endphp
                                    <tr>
                                        <th colspan="5" class="text-right">Status</th>
                                        <th>
                                            @php
                                                $status = App\Services\BulkData::statusPembayaran;
                                            @endphp
                                            @foreach ($status as $s)
                                                @if ($transaction[0]->status == $s['id'])
                                                    <span class="badge badge-danger"> {{ $s['name'] }}</span>
                                                @endif
                                            @endforeach
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right">Order subtotal</th>
                                        <th>Rp. {{ number_format($subtotal, 0, '', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right">Ongkir</th>
                                        <th>Rp. {{ number_format($ongkir, 0, '', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right">Total</th>
                                        <th>Rp. {{ number_format($total, 0, '', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row addresses">
                            <div class="col-md-6 text-right">
                                <h3 class="text-uppercase">Pengirim</h3>
                                <p>{{ $transaction[0]->product->user->name }}
                                    ({{ $transaction[0]->product->user->username }})<br>
                                    Kabupaten Blitar<br>
                                    {{ $transaction[0]->ekspedisi['name'] }} <br>
                                    {{ $transaction[0]->ekspedisi['etd'] }} hari<br>
                                </p>
                            </div>
                            <div class="col-md-6 text-right">
                                @php
                                    $city = App\Models\City::where('id', $transaction[0]->cities_id)->first();
                                @endphp
                                <h3 class="text-uppercase">Penerima</h3>
                                <p>{{ $transaction[0]->user->name }} ({{ $transaction[0]->user->username }}) <br>
                                    {{ $city->type }} {{ $city->city_name }}<br>
                                    {{ $city->postal_code }}<br>
                                </p>
                            </div>
                        </div>
                    </div>
                    @php
                        $bank = App\Models\Setting::where('setting', 'bank')->first();
                    @endphp
                    @if ($bank->tool3 != null)
                        <img src="{{ asset('/data/setting/' . $bank->tool3) }}" alt="{{ $bank->tool1 }}" width="100"
                            style="width:200px">
                    @else
                        <img src="" alt="Logo" width="100">
                    @endif
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;font-size:18px">
                        "Untuk pembayaran, Anda dapat melakukan transfer ke
                        {{ strtoupper($bank->tool1) }} dengan nomor
                        rekening {{ $bank->tool2 }} atas nama {{ $bank->tool4 }}. <br>
                        Harap untuk upload bukti pembayaran dan membayar sesuai total yang tertera, agar pesanan cepat
                        diproses. <br>
                        <strong>
                            "Terima kasih sudah percaya
                            dengan kami!"</strong>
                    </p>
                </div>
                {{-- <div class="col-lg-3 mt-4 mt-lg-0">
                    <!-- CUSTOMER MENU -->
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Menu Customer</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm">
                                <li class="nav-item"><a href="{{ route('cart.myorder') }}" class="nav-link active"><i
                                            class="fa fa-list"></i> My orders</a></li>
                                <li class="nav-item"><a href="{{ route('myaccount') }}" class="nav-link"><i
                                            class="fa fa-user"></i> My account</a></li>
                                <li class="nav-item"><a href="{{ route('logout.supplier-member') }}" class="nav-link"><i
                                            class="fa fa-sign-out"></i>
                                        Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
