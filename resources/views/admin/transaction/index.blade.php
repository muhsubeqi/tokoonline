@extends('admin.layouts.template')
@section('title')
    Admin | Transaksi
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
                    <h1>Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
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
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" id="card_refresh">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.transaction.export') }}" method="get">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status-filter">Status</label>
                                            <select class="custom-select rounded-0" name="status_filter" id="status-filter">
                                                @php
                                                    $statusPembayaran = App\Services\BulkData::statusPembayaran;
                                                @endphp
                                                <option value=""> Semua</option>
                                                @foreach ($statusPembayaran as $row)
                                                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start-date">Mulai Dari</label>
                                            <input type="date" name="start_date" class="form-control date"
                                                id="start-date" placeholder="dd/mm/yyyy">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                            <button class="btn btn-primary" id="button-filter">Filter</button>
                                            <button class="btn btn-danger" id="button-reset">Reset</button>
                                            <button type="submit" class="btn btn-success" id="button-export"><i
                                                    class="fa fa-download mr-1"></i>
                                                Export Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Nama Pembeli</th>
                                        <th>Total</th>
                                        <th>Ekspedisi</th>
                                        <th>Pembayaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Detail --}}
        <div class="modal fade" id="modal_detail">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail Invoice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> <span id="code"></span>
                                    <small class="float-right">Tanggal Pembelian: <span id="buyDate"></span></small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <strong>Penerima</strong>
                                <address>
                                    <span id="customer"></span><br>
                                    <span id="type"></span> <span id="cities_id"></span><br>
                                    <span id="phone"></span><br>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <strong>Espedisi</strong>
                                <address>
                                    <span id="code-ekspedisi"></span><br>
                                    <span id="name-ekspedisi"></span><br>
                                    <span id="etd-ekspedisi"></span><br>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <strong>Status</strong>
                                <address>
                                    <i><span id="status" class="lead"></span></i>
                                </address>
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
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="order-transaction">

                                        </tbody>
                                    </table>
                                    <div class="row">
                                        @php
                                            $bank = App\Models\Setting::where('setting', 'bank')->first();
                                        @endphp
                                        <div class="col-6">
                                            @if ($bank->tool3 != null)
                                                <img src="{{ asset('/data/setting/' . $bank->tool3) }}"
                                                    alt="{{ $bank->tool1 }}" width="100">
                                            @else
                                                <img src="" alt="Logo" width="100">
                                            @endif
                                            <p class="text-muted well well-sm shadow-none"
                                                style="margin-top: 10px;font-size:18px">
                                                "Untuk pembayaran, Anda dapat melakukan transfer ke
                                                {{ strtoupper($bank->tool1) }} dengan nomor
                                                rekening {{ $bank->tool2 }} atas nama {{ $bank->tool4 }}. <br> <strong>
                                                    Terima kasih sudah percaya
                                                    dengan kami!"</strong>
                                            </p>
                                        </div>

                                        <div class="col-6">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td id="subtotal"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ongkir:</th>
                                                        <td id="ongkir-ekspedisi"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td id="grand-total"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                        <div class="d-flex">
                            <form action="{{ route('admin.transaction.print') }}" method="GET" target="_blank">
                                @csrf
                                <input type="hidden" id="code-print" name="code_print">
                                <button type="submit" class="btn btn-info float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Print
                                </button>
                            </form>
                            <form action="{{ route('admin.transaction.pdf') }}" method="GET">
                                @csrf
                                <input type="hidden" id="code-pdf" name="code_pdf">
                                <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal Pembayaran --}}
        <div class="modal fade" id="modal_pembayaran" tabindex="-1" role="dialog" aria-labelledby="modal_edit"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title_edit">Bukti Pembayaran </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id-edit" name="id_edit">
                        <div class="form-group">
                            <img src="" class="img-fluid" id="photo-preview"
                                style="width: 100%; height: 100%; object-fit:cover;" alt="photo">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    {{-- Datatable --}}
    <script src="{{ asset('/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            // data table and card refresh
            var table1 = dataTable('#table');
            $('#card_refresh').click(function(e) {
                table1.ajax.reload();
            });
        });
    </script>
    <script>
        function orderTransaction(trans) {
            $('#order-transaction').empty();
            var i = 1;
            var url = "{{ asset('/data/product/') }}";
            console.log(url);
            trans.forEach(t => {
                var content = `
                                <tr>
                                    <td class="align-middle">${i}</td>
                                    <td class="align-middle"><img src="${url}/${t.product.photo}" alt="${t.product.name}" class="img-fluid" width="50"></td>
                                    <td class="align-middle">${t.product.name}</td>
                                    <td class="align-middle">${t.product.price}</td>
                                    <td class="align-middle">${t.qty}</td>
                                    <td class="align-middle">${t.subtotal}</td>
                                </tr>
                            `;
                i++;
                $('#order-transaction').append(content);
            });
        }

        function formatRupiah(number) {
            return 'Rp. ' + number.toLocaleString('id-ID');
        }

        $(document).ready(function() {

            $('#modal_detail').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var code = button.data('code');
                var name = button.data('name');
                var cities_id = button.data('cities_id');
                var type = button.data('type');
                var status = button.data('status');
                var trans = button.data('trans');
                var subtotal = button.data('subtotal');
                subtotal = formatRupiah(subtotal);
                var ongkir = button.data('ongkir');
                ongkir = formatRupiah(ongkir);
                var codeEks = button.data('code-eks');
                var nameEks = button.data('name-eks');
                var etdEks = button.data('etd-eks');
                var buyDate = button.data('buy-date');

                var grandTotal = button.data('grandtotal');

                grandTotal = formatRupiah(grandTotal);

                trans = decodeURIComponent(trans);
                trans = JSON.parse(trans);
                orderTransaction(trans);

                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#code').html(code);
                modal.find('#customer').html(name);
                modal.find('#cities_id').html(cities_id);
                modal.find('#type').html(type);
                modal.find('#status').html(status);
                modal.find('#subtotal').html(subtotal);
                modal.find('#ongkir-ekspedisi').html(ongkir);
                modal.find('#code-ekspedisi').html(codeEks);
                modal.find('#name-ekspedisi').html(nameEks);
                modal.find('#etd-ekspedisi').html(etdEks);
                modal.find('#grand-total').html(grandTotal);
                modal.find('#code-pdf').val(code);
                modal.find('#code-print').val(code);
                modal.find('#buyDate').html(buyDate);

            })

            $('#modal_pembayaran').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var photo = button.data('photo');

                var modal = $(this);
                modal.find('#id').val(id);
                modal.find("#photo-old").val(photo);
                var tes = modal.find("#photo-preview").attr('src', '/data/transaction/' +
                    photo);
            })
        });
    </script>
    <script>
        function editStatus(event, code) {
            event.preventDefault();
            var status = event.target.value;
            var url = "{{ route('admin.transaction.status') }}";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    code: code,
                    status: status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#table').DataTable().ajax.reload(null, false);
                    swalToast(response.status, response.message);
                }
            });
        }

        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var name = event.target.querySelector('input[name="code"]').value;
            Swal.fire({
                title: 'Yakin ingin menghapus data produk dengan nama ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.transaction.delete') }}";
                    var fd = new FormData($(event.target)[0]);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            $('#table').DataTable().ajax.reload(null, false);
                            swalToast(response.status, response.message);
                        }
                    });
                }
            })
        }

        function dataTable(name) {
            var url = "{{ route('admin.transaction.getData') }}";
            var datatable = $(name).DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    type: 'GET',
                    data: function(d) {
                        d.statusFilter = $('#status-filter').val();
                        d.startDate = $('#start-date').val();
                        d.endDate = $('#end-date').val();
                    }
                },
                deferRender: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                    searchPlaceholder: "Cari...",
                },
                columns: [{
                        "data": "id",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: 'align-middle'
                    },
                    {
                        data: 'code',
                        name: 'code',
                        className: 'align-middle',
                    },
                    {
                        data: 'username',
                        name: 'username',
                        className: 'align-middle'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'align-middle'
                    },
                    {
                        data: 'ekspedisi',
                        name: 'ekspedisi',
                        className: 'align-middle'
                    },
                    {
                        data: 'pembayaran',
                        name: 'pembayaran',
                        className: 'align-middle'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'align-middle'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true,
                        className: 'align-middle'
                    },
                ]
            })

            $('#button-filter').click(function(e) {
                e.preventDefault();
                var statusFilter = $('#status-filter').val();
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();

                if (startDate !== '' && endDate === '') {
                    alert('jika mengisi (mulai dari), isi juga (sampai dari)')
                }

                $('#table').DataTable().ajax.reload(null, false);
            });

            $('#button-reset').click(function(e) {
                e.preventDefault();
                var statusFilter = $('#status-filter').val('');
                var startDate = $('#start-date').val('');
                var endDate = $('#end-date').val('');

                $('#table').DataTable().ajax.reload(null, false);
            });

            datatable.buttons().container().appendTo(name + '_wrapper .col-md-6:eq(0)');
            return datatable;
        }


        function cardRefresh() {
            var cardRefresh = document.querySelector('#card_refresh');
            cardRefresh.click();
        }

        function swalToast(status, message) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                customClass: 'toast-content'
            });
            if (status == 200) {
                Toast.fire({
                    icon: 'success',
                    title: message
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: message
                });
            }
        }
    </script>
@endpush
