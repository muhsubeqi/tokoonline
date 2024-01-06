<table>
    <thead>
        @if ($startDate != null || $endDate != null)
            <tr>
                <td colspan="2" style="font-size: 12px; text-align:left;font-weight:bold">Tanggal Mulai :</td>
                <td colspan="2" style="font-size: 12px; text-align:left;">{{ date('d M Y', strtotime($startDate)) }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 12px; text-align:left;font-weight:bold">Tanggal Sampai :</td>
                <td colspan="2" style="font-size: 12px; text-align:left;">{{ date('d M Y', strtotime($endDate)) }}</td>
            </tr>
            <tr></tr>
        @endif
        <tr>
            <th style="background-color: yellow;color:black;width:50px">No</th>
            <th style="background-color: yellow;color:black;width:150px">Invoice</th>
            <th style="background-color: yellow;color:black;width:100px">Customer</th>
            <th style="background-color: yellow;color:black;width:200px">Nama Produk</th>
            <th style="background-color: yellow;color:black;width:100px">Harga Produk</th>
            <th style="background-color: yellow;color:black;width:50px">Qty</th>
            <th style="background-color: yellow;color:black;width:100px">Subtotal</th>
            <th style="background-color: yellow;color:black;width:100px">Ongkir</th>
            <th style="background-color: yellow;color:black;width:100px">Total</th>
            <th style="background-color: yellow;color:black;width:100px">Ekspedisi</th>
            <th style="background-color: yellow;color:black;width:50px">City</th>
            <th style="background-color: yellow;color:black;width:100px">Status</th>
            <th style="background-color: yellow;color:black;width:100px">Date</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $productTotal = 0;
            $costTotal = 0;
            $allTotal = 0;
        @endphp
        @foreach ($reports as $report)
            @php
                $products = App\Models\Transaction::where('code', $report->code)->get();
                $subtotal = $products->sum('subtotal');
                $total = $subtotal + $report->ekspedisi['value'];
                $productTotal += $subtotal;
                $costTotal += $report->ekspedisi['value'];
                $allTotal += $total;
            @endphp
            @foreach ($products as $index => $product)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">{{ $i++ }}</td>
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">{{ $product->code }}</td>
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            {{ $product->user->username }}</td>
                    @endif
                    <td style="vertical-align:middle">{{ $product->product->name }}</td>
                    <td style="vertical-align:middle">{{ $product->product->price }}</td>
                    <td style="vertical-align:middle">{{ $product->qty }}</td>
                    @if ($index === 0)
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            {{ $subtotal }}</td>
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            {{ $product->ekspedisi['value'] }}</td>
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            {{ $subtotal + $product->ekspedisi['value'] }}</td>
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            {{ $product->city->city_name }}</td>
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            {{ $product->ekspedisi['code'] }}</td>

                        @php
                            $status = App\Services\BulkData::statusPembayaran;
                        @endphp
                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            @foreach ($status as $s)
                                @if ($s['id'] == $product->status)
                                    {{ strtoupper($s['name']) }}
                                @endif
                            @endforeach
                        </td>

                        <td rowspan="{{ count($products) }}" style="vertical-align:middle">
                            {{ date('d/M/Y', strtotime($product->created_at)) }}
                        </td>
                    @endif
                </tr>
            @endforeach
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="10" style="font-size: 15px; text-align:right;font-weight:bold">Total Pembelian Produk :</td>
            <td colspan="3" style="font-size: 15px;text-align:right;">Rp.
                {{ number_format($productTotal, 0, '', '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="10" style="font-size: 15px; text-align:right;font-weight:bold">Total Ongkir :</td>
            <td colspan="3" style="font-size: 15px;text-align:right;">Rp.
                {{ number_format($costTotal, 0, '', '.') }}
            </td>
        </tr>
        <tr>
            <td colspan="10" style="font-size: 15px; text-align:right;font-weight:bold">Total Pemasukan :</td>
            <td colspan="3" style="font-size: 15px;text-align:right;">Rp.
                {{ number_format($productTotal - $costTotal, 0, '', '.') }}
            </td>
        </tr>
    </tbody>
</table>
