@extends('homepage.layouts.template')
@section('title')
    My Order
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">My Orders</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">My Orders</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar mb-0">
                <div id="customer-orders" class="col-md-12">
                    @php
                        $storePhone = App\Models\Setting::where('setting', 'store_phone')->first();
                        $phone = substr($storePhone->tool1, 1);
                    @endphp
                    <p class="lead text-muted">Jika anda memiliki pertanyaan, jangan ragu untuk menghubungi kami, pusat
                        layanan kami bekerja untuk anda 24 jam.
                        <a href="https://wa.me/62{{ @$phone }}" class="btn btn-success" target="_blank"><i
                                class="fa fa-whatsapp">
                                WhatsApp</i></a>
                    </p>
                    <div class="box mt-0 mb-lg-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Tanggal</th>
                                        <th>Ekspedisi</th>
                                        <th>Alamat</th>
                                        <th>Subtotal</th>
                                        <th>Ongkir</th>
                                        <th>Total Semua</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $row)
                                        @php
                                            $city = App\Models\City::where('id', $row->cities_id)->first();
                                            $city = $city->type . ' ' . $city->city_name;
                                        @endphp
                                        <tr>
                                            <td>{{ $row->code }}</td>
                                            <td>{{ date('d/m/Y', strtotime($row->created_at)) }}</td>
                                            <td>{{ $row->ekspedisi['code'] }}</td>
                                            <td>{{ $city }}</td>
                                            <td>{{ number_format($row->subtotal, 0, '', '.') }}</td>
                                            <td>{{ number_format($row->ekspedisi['value'], 0, '', '.') }}</td>
                                            <td>{{ number_format($row->subtotal + $row->ekspedisi['value'], 0, '', '.') }}
                                            </td>
                                            <td>
                                                @php
                                                    $status = App\Services\BulkData::statusPembayaran;
                                                @endphp
                                                @foreach ($status as $s)
                                                    @if ($row->status == $s['id'])
                                                        <span class="badge badge-danger">{{ $s['name'] }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#upload-modal"
                                                    class="upload-btn btn btn-template-outlined btn-sm m-1"
                                                    data-id="{{ $row->id }}" data-code="{{ $row->code }}"
                                                    data-photo="{{ $row->photo }}"><i class="fa fa-upload"></i><span
                                                        class="d-none d-md-inline-block"></span></button>
                                                <a href="{{ route('cart.myorder.detail', ['code' => $row->code]) }}"
                                                    class="btn btn-template-outlined btn-sm m-1"><i
                                                        class="fa fa-eye"></i></a>
                                                <form action="" onsubmit="deleteData(event)" method="POST"
                                                    class="d-md-inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $row->id }}">
                                                    <input type="hidden" name="code" value="{{ $row->code }}">
                                                    <button type="submit"
                                                        class="upload-btn btn btn-template-outlined btn-sm m-1">
                                                        <i class="fa fa-trash"></i><span
                                                            class="d-none d-md-inline-block"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-center">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                    <br>
                    @php
                        $bank = App\Models\Setting::where('setting', 'bank')->first();
                    @endphp
                    @if ($bank->tool3 != null)
                        <img src="{{ asset('/data/setting/' . $bank->tool3) }}" alt="{{ $bank->tool1 }}" width="100">
                    @else
                        <img src="" alt="Logo" width="100">
                    @endif
                    <p class="text-muted well well-sm shadow-none lead" style="margin-top: 10px;">
                        Untuk pembayaran, Anda dapat melakukan transfer ke
                        {{ strtoupper($bank->tool1) }} dengan nomor
                        rekening {{ $bank->tool2 }} atas nama {{ $bank->tool4 }}. <br>
                        Harap untuk upload bukti pembayaran dan membayar sesuai total yang tertera, agar pesanan cepat
                        diproses.
                        <br>
                        <strong>
                            "Terima kasih sudah percaya
                            dengan kami!"</strong>
                    </p>
                </div>
                {{-- <div class="col-md-3 mt-4 mt-md-0">
                    <!-- CUSTOMER MENU -->
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-heading">
                            <h3 class="h4 panel-title">Menu Customer</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills flex-column text-sm">
                                <li class="nav-item"><a href="{{ route('cart.myorder') }}"
                                        class="nav-link {{ request()->routeIs('cart.myorder') ? 'active' : '' }}"><i
                                            class="fa fa-list"></i> My orders</a></li>
                                <li class="nav-item"><a href="{{ route('myaccount') }}"
                                        class="nav-link {{ request()->routeIs('myaccount') ? 'active' : '' }}"><i
                                            class="fa fa-user"></i> My account</a></li>
                                <li class="nav-item"><a href="{{ route('logout.supplier-member') }}" class="nav-link"><i
                                            class="fa fa-sign-out"></i>
                                        Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true"
        class="modal fade">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="uploadModalLabel" class="modal-title">Upload Bukti Pembayaran</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cart.myorder.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="code" id="code">

                        <div class="form-group">
                            <input type="hidden" name="photo_old" id="photo-old">
                            <img src="" class="img-fluid" id="photo-preview"
                                style="width: 100%; height: 100%; object-fit:cover;" alt="photo">
                            <input id="photo" name="photo" type="file" placeholder="Upload Bukti Pembayaran"
                                class="form-control mt-3" onchange="previewImage()" accept="image/*">
                        </div>
                        <p class="text-center">
                            <button class="btn btn-template-outlined"><i class="fa fa-upload"></i> Upload</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function previewImage() {
            const photo = document.querySelector("#photo");
            const imgPreview = document.querySelector("#photo-preview");
            const oFReader = new FileReader();
            oFReader.readAsDataURL(photo.files[0]);
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#upload-modal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var code = button.data('code');
                var photo = button.data('photo');

                var modal = $(this);
                modal.find('#id').val(id);
                modal.find('#code').val(code);
                modal.find("#photo-old").val(photo);
                var tes = modal.find("#photo-preview").attr('src', '/data/transaction/' + photo);
            })
        });
    </script>
    <script>
        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var name = event.target.querySelector('input[name="code"]').value;
            Swal.fire({
                title: 'Yakin ingin menghapus data pesanan dengan invoice ' + name + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('cart.myorder.delete') }}";
                    var fd = new FormData($(event.target)[0]);
                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            if (response.status != 500) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1000,
                                    didClose: () => {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1000,
                                    didClose: () => {
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            })
        }
    </script>
@endpush
