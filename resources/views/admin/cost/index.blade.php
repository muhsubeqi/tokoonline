@extends('admin.layouts.template')
@section('title')
    Admin | Hitung Ongkir
@endsection
@push('css')
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hitung Ongkir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Hitung Ongkir</a></li>
                        <li class="breadcrumb-item active">Daftar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Perhitungan Ongkir</h3>
                        </div>
                        <form action="" method="post" id="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="start-city">Kota Asal</label>
                                    <input type="hidden" name="start_city" value="{{ $city->id }}">
                                    <input type="text" class="form-control" id="start-city"
                                        placeholder="Kota asal pengiriman"
                                        value="{{ $city->type }} {{ $city->city_name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="end-city">Kota Tujuan</label>
                                    <select class="form-control select2bs4" name="end_city" id="end-city"
                                        style="width: 100%;">
                                        <option selected="selected" disabled>Pilih..</option>
                                        @php
                                            $cities = App\Models\City::all();
                                        @endphp
                                        @foreach ($cities as $row)
                                            <option value="{{ $row['id'] }}">{{ $row['type'] }} {{ $row['city_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="weight">Berat Kiriman (gram)</label>
                                    <input type="number" class="form-control" id="weight" name="weight"
                                        placeholder="Berat Kiriman (gram)">
                                </div>
                                <div class="form-group">
                                    <label for="ekspedisi">Ekspedisi</label>
                                    <select class="form-control select2bs4" name="ekspedisi" id="ekspedisi"
                                        style="width: 100%;">
                                        <option selected="selected" disabled>Pilih..</option>
                                        <option value="jne">Jalur Nugraha Eka (JNE)</option>
                                        <option value="pos">POS Indonesia (POS)</option>
                                        <option value="tiki">Citra Van Titipan Kilat (TIKI)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="button-submit">Periksa Ongkir</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary" id="card-show">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-text-width"></i>
                                Hasil Perhitungan Ongkir
                            </h3>
                        </div>
                        <div class="card-body">
                            <dl>
                                <dt>Code Ekspedisi</dt>
                                <dd id="code"></dd>
                                <dt>Nama Ekspedisi</dt>
                                <dd id="name"></dd>
                                <dt>Biaya Ongkir</dt>
                                <dd id="cost"></dd>
                                <dt>Estimasi Diterima</dt>
                                <dd id="etd"></dd>
                            </dl>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    {{-- Select2 --}}
    <script src="{{ asset('/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        $('#form').submit(function(e) {
            e.preventDefault();
            var url = "{{ route('admin.cost.check') }}";
            var fd = new FormData($(this)[0]);

            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#button-submit').attr('disabled', true);
                    var content = `<div class="overlay">
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                        </div>`;
                    $('#card-show').append(content);
                },
                success: function(response) {
                    $('#button-submit').attr('disabled', false);
                    $('.overlay').remove();
                    $('#code').html(response.code.toUpperCase());
                    $('#name').html(response.name);
                    $('#cost').html(response.costs[0].cost[0].value);
                    $('#etd').html(response.costs[0].cost[0].etd);
                }
            });
        });
    </script>
@endpush
