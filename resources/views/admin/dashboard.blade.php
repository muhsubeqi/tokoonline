@extends('admin.layouts.template')
@section('title', 'Admin | Dashboard')
@push('css')
    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <style>
        .todo-list li {
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">/ Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            @php
                                $user = \App\Models\User::all();
                            @endphp
                            <h3>
                                {{ count($user) }}
                            </h3>
                            <p>Data User</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.user') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            @php
                                $product = \App\Models\Product::all();
                            @endphp
                            <h3>
                                {{ count($product) }}
                            </h3>
                            <p>Data Produk</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('admin.product') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            @php
                                $transaction = \App\Models\Transaction::groupBy('code')->get();
                            @endphp
                            <h3>
                                {{ count($transaction) }}
                            </h3>
                            <p>Data Transaksi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('admin.transaction') }}" class="small-box-footer">Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Info</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="info-box">
                                    @if (auth()->user()->image != null)
                                        <span class="info-box-icon"><img
                                                src="{{ asset('/data/user/' . auth()->user()->image) }}"
                                                style="width: 70px;height:70px;object-fit:cover" alt="user"></span>
                                    @else
                                        <span class="info-box-icon"><img src="{{ asset('/admin/dist/img/avatar5.png') }}"
                                                width="200" alt=""></span>
                                    @endif
                                    <div class="info-box-content">
                                        @php
                                            $nama = App\Models\Setting::where('setting', 'store_name')->first();
                                        @endphp
                                        <span class="info-box-text">Selamat Datang di Sistem Informasi Penjualan
                                            {{ @$nama->tool1 }},</span>
                                        <span class="info-box-text">Anda masuk dengan akun
                                            <b>{{ auth()->user()['email'] }}</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Data Transaksi Terakhir</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                            $transaction = \App\Models\Transaction::groupBy('code')
                                                ->orderBy('id', 'DESC')
                                                ->limit(5)
                                                ->get();
                                        @endphp
                                        @foreach ($transaction as $row)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $row->code }}</td>
                                                <td>{{ $row->user->username }}</td>
                                                <td>{{ $row->city->city_name }}</td>
                                                <td>{{ number_format($row->subtotal, 0, '', '.') }}</td>
                                                @php
                                                    $status = App\Services\BulkData::statusPembayaran;
                                                @endphp
                                                <td>
                                                    @foreach ($status as $s)
                                                        @if ($row->status == $s['id'])
                                                            {{ $s['name'] }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.transaction') }}" class="btn btn-sm btn-success w-100">Lihat
                                Selengkapnya...</a>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('script')
    {{-- Sweet Alert --}}
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if (Session::has('success-login'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{!! Session::get('success-login') !!}",
                timer: 5000
            })
        @endif
    </script>
@endpush
