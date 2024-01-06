@extends('homepage.layouts.template')
@section('title')
    Formulir
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Formulir</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Formulir</li>
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
                <div id="checkout" class="col-lg-9">
                    <form method="post" action="{{ route('cart.form.transaction') }}" id="form-add">
                        @csrf
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Nama (Member)</label>
                                        <input id="name" name="name" value="{{ auth()->user()->name }}"
                                            type="text" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email (Member)</label>
                                        <input id="email" name="email" value="{{ auth()->user()->email }}"
                                            type="text" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="city">Kota</label>
                                        <select id="city" name="city_id" class="form-control" onchange="check()"
                                            required>
                                            <option value="">Pilih Kota ...</option>
                                            @foreach ($city as $row)
                                                <option value="{{ $row->id }}">{{ $row->city_name }}
                                                    ({{ $row->type }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="province">Provinsi</label>
                                        <input id="province" name="province" type="text" class="form-control"
                                            placeholder="Pilih Kota dahulu.." readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="portal-code">Kode Pos</label>
                                        <input id="portal-code" name="portal_code" type="number" class="form-control"
                                            placeholder="Pilih Kota dahulu.." readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="ekspedisi">Ekspedisi</label>
                                        <select id="ekspedisi" name="ekspedisi" class="form-control">
                                            <option value="jne">Jalur Nugraha Eka (JNE)</option>
                                            <option value="pos">POS Indonesia (POS)</option>
                                            <option value="tiki">Citra Van Titipan Kilat (TIKI)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer d-flex flex-wrap align-items-center justify-content-between">
                            <div class="left-col"><a href="shop-basket.html" class="btn btn-secondary mt-0"><i
                                        class="fa fa-chevron-left"></i>Kembali</a></div>
                            <div class="right-col">
                                <button type="submit" id="form-submit" class="btn btn-template-main">Lanjutkan<i
                                        class="fa fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </form>
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
@push('script')
    <script>
        function check() {
            var id = $('#city').val();
            var url = "{{ route('cart.form.getCity') }}";
            $.ajax({
                type: "GET",
                url: url,
                data: {
                    id: id,
                },
                success: function(response) {
                    console.log(response);
                    $('#province').val(response.province.province);
                    $('#portal-code').val(response.postal_code);
                }
            });
        }
    </script>
@endpush
