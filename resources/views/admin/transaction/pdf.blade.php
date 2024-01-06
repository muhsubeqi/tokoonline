<!DOCTYPE html>
<html>

<head>
    <title>Cetak PDF</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> <span id="code">{{ $transaction[0]->code }}</span>
                    <small class="float-right" style="float: right">Tanggal Pembelian:
                        {{ date('d M Y', strtotime($transaction[0]->created_at)) }}</small>
                </h4>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <strong>Penerima</strong>
                <address>
                    <span id="customer">{{ $transaction[0]->user->name }}</span><br>
                    <span id="address">{{ $transaction[0]->city->city_name }}</span><br>
                    <span id="phone"></span><br>
                </address>
            </div>
            <br>
            <div class="col-sm-4 invoice-col">
                <strong>Espedisi</strong>
                <address>
                    <span id="code-ekspedisi">{{ $transaction[0]->ekspedisi['code'] }}</span><br>
                    <span id="name-ekspedisi">{{ $transaction[0]->ekspedisi['name'] }}</span><br>
                    <span id="etd-ekspedisi">{{ $transaction[0]->ekspedisi['etd'] }}</span><br>
                </address>
            </div>
            <br>
            <div class="col-sm-4 invoice-col">
                <strong>Status</strong>
                <address>
                    <span id="status" class="btn btn-sm btn-danger text-bold">
                        @php
                            $status = App\Services\BulkData::statusPembayaran;
                        @endphp
                        @foreach ($status as $s)
                            @if ($transaction[0]->status == $s['id'])
                                {{ $s['name'] }}
                            @endif
                        @endforeach
                </address>
            </div>
            <br>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah (Qty)</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="order-transaction">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($transaction as $t)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $t->product->name }}</td>
                                    <td style="text-align: center">{{ $t->product->price }}</td>
                                    <td style="text-align: center">{{ $t->qty }}</td>
                                    <td style="text-align: center">{{ $t->subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            @php
                                $bank = App\Models\Setting::where('setting', 'bank')->first();
                            @endphp
                            <p class="lead">Cara Pembayaran:</p>
                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                "Untuk pembayaran, Anda dapat melakukan transfer ke {{ @$bank->tool1 }} dengan nomor
                                rekening {{ @$bank->tool2 }} atas nama {{ $bank->tool3 }}. Terima kasih atas
                                kerjasamanya!"
                            </p>
                        </div>

                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        @php
                                            $subtotal = $transaction->sum('subtotal');
                                            $ongkir = $transaction[0]->ekspedisi['value'];
                                            $total = $subtotal + $ongkir;
                                        @endphp
                                        <td id="subtotal">{{ $subtotal }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ongkir:</th>
                                        <td id="ongkir-ekspedisi">{{ $ongkir }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td id="grand-total">{{ $total }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
