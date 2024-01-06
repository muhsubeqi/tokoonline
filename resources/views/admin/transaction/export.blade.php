<table>
    <thead>
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
        @endphp
        @foreach ($transactions as $transaction)
            @php
                $products = App\Models\Transaction::where('code', $transaction->code)->get();
                $subtotal = $products->sum('subtotal');
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
    </tbody>
</table>
