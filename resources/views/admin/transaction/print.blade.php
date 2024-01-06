<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('/admin/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/admin/dist/css/adminlte.min.css?v=3.2.0') }}">

</head>

<body>
    <div class="wrapper">

        <section class="invoice">

            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fas fa-globe"></i> ART PRODUCTION
                        <small class="float-right">Tanggal Pembelian :
                            {{ date('d M Y', strtotime($transaction[0]->created_at)) }}</small>
                    </h2>
                </div>

            </div>

            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    Pengirim
                    <address>
                        @php
                            $address = App\Models\Setting::where('setting', 'store_address')->first();
                            $city = App\Models\Setting::where('setting', 'store_city')->first();
                            $email = App\Models\Setting::where('setting', 'store_email')->first();
                            $phone = App\Models\Setting::where('setting', 'store_phone')->first();
                            $dataCity = App\Models\City::all();
                        @endphp
                        <strong>{{ $transaction[0]->product->user->name }}</strong><br>
                        {{ @$address->tool2 }}
                        <br>
                        @foreach ($dataCity as $c)
                            @if (@$city->tool1 == $c->id)
                                {{ $c->type }} {{ $c->city_name }}
                            @endif
                        @endforeach
                        <br>
                        Phone: {{ @$phone->tool1 }}<br>
                        Email: {{ @$email->tool1 }}</a>
                    </address>
                </div>

                <div class="col-sm-4 invoice-col">
                    Penerima
                    <address>
                        <strong>{{ $transaction[0]->user->name }} ({{ $transaction[0]->user->username }})</strong><br>
                        {{ $transaction[0]->city->type }} {{ $transaction[0]->city->city_name }}<br>
                        {{ $transaction[0]->city->province->province }}, {{ $transaction[0]->city->postal_code }}<br>
                        Phone: {{ $transaction[0]->user->phone }}<br>
                        Email: {{ $transaction[0]->user->email }}</a>
                    </address>
                </div>

                <div class="col-sm-4 invoice-col">
                    <br><br>
                    <h1 class="fs-5 text-danger"><i>{{ $transaction[0]->code }}</i></h1><br>
                </div>

            </div>


            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah (Qty)</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($transaction as $t)
                                <tr>
                                    <td class="align-middle">{{ $i++ }}</td>
                                    <td class="align-middle"><img
                                            src="{{ asset('data/product/' . $t->product->photo) }}"
                                            alt="{{ $t->product->name }}" class="img-fluid" width="50"></td>
                                    <td class="align-middle">{{ $t->product->name }}</td>
                                    <td class="align-middle">Rp. {{ number_format($t->product->price, 0, '', '.') }}
                                    </td>
                                    <td class="align-middle">{{ $t->qty }}</td>
                                    <td class="align-middle">Rp. {{ number_format($t->subtotal, 0, '', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row">

                @php
                    $bank = App\Models\Setting::where('setting', 'bank')->first();
                @endphp
                <div class="col-6">
                    @if ($bank->tool3 != null)
                        <img src="{{ asset('/data/setting/' . $bank->tool3) }}" alt="{{ $bank->tool1 }}"
                            width="100">
                    @else
                        <img src="" alt="Logo" width="100">
                    @endif
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;font-size:18px">
                        "Untuk pembayaran, Anda dapat melakukan transfer ke
                        {{ strtoupper($bank->tool1) }} dengan nomor
                        rekening {{ $bank->tool2 }} atas nama {{ $bank->tool3 }}. <br> <strong> Terima kasih sudah
                            percaya
                            dengan kami!"</strong>
                    </p>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            @php
                                $subtotal = $transaction->sum('subtotal');
                                $ongkir = $transaction[0]->ekspedisi['value'];
                                $total = $subtotal + $ongkir;
                            @endphp
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>Rp. {{ number_format($subtotal, 0, '', '.') }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Ongkir:</th>
                                <td>Rp. {{ number_format($ongkir, 0, '', '.') }}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Total:</th>
                                <td>Rp. {{ number_format($total, 0, '', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>

        </section>

    </div>
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
