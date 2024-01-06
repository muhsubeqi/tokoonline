@extends('homepage.layouts.template')
@section('title')
    Keranjang
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Keranjang</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Keranjang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar">
                <div class="col-lg-12">
                    <p class="text-muted lead">Anda mempunyai {{ Cart::count() }} produk di keranjangmu</p>
                </div>
                <div id="basket" class="col-lg-9">
                    <div class="box mt-0 pb-0 no-horizontal-padding">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="1">Produk</th>
                                        <th>Jumlah Order</th>
                                        <th>harga</th>
                                        <th colspan="2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $row)
                                        @csrf
                                        <tr>
                                            <td><a href="#">{{ $row->name }}</a></td>
                                            @php
                                                $product = \App\Models\Product::where('name', $row->name)->first();
                                            @endphp
                                            <td>
                                                {{ $row->qty }}
                                            </td>
                                            <td>Rp. {{ number_format($row->price, 0, '', '.') }}</td>
                                            <td>Rp. {{ number_format($row->subtotal, 0, '', '.') }}</td>
                                            <td>
                                                <a href="{{ route('cart.delete', ['rowId' => $row->rowId]) }}"
                                                    class="btn btn-sm btn-danger m-1" style="margin-top: 0"><i
                                                        class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th colspan="2">Rp. {{ number_format(Cart::subtotal(), 0, '', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="box-footer d-flex justify-content-between align-items-center">
                            <div class="left-col"><a href="{{ route('product') }}" class="btn btn-secondary mt-0"><i
                                        class="fa fa-chevron-left"></i> Continue shopping</a></div>
                            <div class="right-col">
                                <a href="{{ route('cart.form') }}" id="form-submit"
                                    class="btn btn-template-outlined">Proceed to checkout <i
                                        class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div id="order-summary" class="box mt-0 mb-4 p-0">
                        <div class="box-header mt-0">
                            <h3>Total Pembelian</h3>
                        </div>
                        <p class="text-muted">Jumlah pesanan ini belum termasuk ongkir, anda dapat melihat ongkir pada
                            halaman selanjutnya setelah mengisi form pengiriman</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr class="total">
                                        <td>Total</td>
                                        <th>Rp. {{ number_format(Cart::subtotal(), 0, '', '.') }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
