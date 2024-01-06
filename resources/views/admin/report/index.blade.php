@extends('admin.layouts.template')
@section('title')
    Admin | Laporan
@endsection
@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    {{-- Datatable --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <style>
        input.date {
            position: relative;
            overflow: hidden;
        }

        input.date::-webkit-calendar-picker-indicator {
            display: block;
            top: 0;
            left: 0;
            background: #0000;
            position: absolute;
            transform: scale(12)
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                        <li class="breadcrumb-item active">Daftar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="fas fa-bullhorn"></i> Info!</h5>
                        Jika memilih tanggal (mulai dari), pastikan juga memilih tanggal (sampai dari) agar filter atau
                        export bisa diterapkan
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Lihat Pemasukan
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="" method="get" id="form-income">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start-date">Mulai Dari</label>
                                            <input type="date" name="start_date" class="form-control date"
                                                id="start-date" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end-date">Sampai Dari</label>
                                            <input type="date" name="end_date" class="form-control date" id="end-date"
                                                placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary" id="button-submit">Filter</button>
                                            <button class="btn btn-danger" id="button-reset">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row mt-4">
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Total Pembelian
                                                Produk</span>
                                            <span class="info-box-number text-center text-muted mb-0"
                                                id="product-total"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Total Ongkir</span>
                                            <span class="info-box-number text-center text-muted mb-0"
                                                id="cost-total"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="info-box bg-light">
                                        <div class="info-box-content">
                                            <span class="info-box-text text-center text-muted">Total Pemasukan
                                                (Bersih)</span>
                                            <span class="info-box-number text-center text-muted mb-0"
                                                id="income-total"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Download Laporan Pemasukan
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.report.export') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start-date2">Mulai Dari</label>
                                            <input type="date" name="start_date" class="form-control date"
                                                id="start-date2" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end-date2">Sampai Dari</label>
                                            <input type="date" name="end_date" class="form-control date"
                                                id="end-date2" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success" id="button-export"><i
                                                    class="fa fa-download mr-1"></i>
                                                Export Excel</button>
                                            <button class="btn btn-danger" id="button-reset2">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $('#button-reset').click(function(e) {
                e.preventDefault();
                var startDate = $('#start-date').val('');
                var endDate = $('#end-date').val('');

                $('#product-total').html('');
                $('#cost-total').html('');
                $('#income-total').html('');
            });

            $('#button-reset2').click(function(e) {
                e.preventDefault();
                var startDate = $('#start-date2').val('');
                var endDate = $('#end-date2').val('');
            });

            $('#form-income').submit(function(e) {
                e.preventDefault();
                var url = "{{ route('admin.report.income') }}";
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
                        $('.info-box').append(content);
                    },
                    success: function(response) {
                        $('#button-submit').attr('disabled', false);
                        $('.overlay').remove();
                        $('#product-total').html(formatRupiah(response.productTotal));
                        $('#cost-total').html(formatRupiah(response.costTotal));
                        $('#income-total').html(formatRupiah(response.incomeTotal));
                    }
                });
            });
        });
    </script>
    <script>
        function formatRupiah(number) {
            return 'Rp. ' + number.toLocaleString('id-ID');
        }
    </script>
@endpush
