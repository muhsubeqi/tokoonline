@extends('admin.layouts.template')
@section('title', 'Admin | Setting')
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
                    <h1>Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Setting</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.setting.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">General</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="store_name">Nama Toko</label>
                                    <input type="text" id="store_name" name="store_name" value="{{ $storeName->tool1 }}"
                                        class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="store_address">Alamat Lengkap Toko</label>
                                    <textarea id="store_address" name="store_address" class="form-control" rows="3">{{ $storeAddress->tool2 }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="store_city">Kota/Kab Toko</label>
                                    <select id="store_city" name="store_city" class="form-control select2bs4" required>
                                        @php
                                            $data = App\Models\City::all();
                                        @endphp
                                        @foreach ($data as $d)
                                            @if ($storeCity->tool1 == $d->id)
                                                <option value="{{ $d->id }}" selected>{{ $d->type }}
                                                    {{ $d->city_name }}
                                                </option>
                                            @else
                                                <option value="{{ $d->id }}">{{ $d->type }} {{ $d->city_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <small>*Digunakan untuk alamat pengirim</small>
                                </div>
                                <div class="form-group">
                                    <label for="store_phone">Telepon</label>
                                    <input type="number" id="store_phone" name="store_phone" class="form-control"
                                        value="{{ $storePhone->tool1 }}">
                                </div>
                                <div class="form-group">
                                    <label for="store_email">Email</label>
                                    <input type="email" id="store_email" name="store_email" class="form-control"
                                        value="{{ $storeEmail->tool1 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="announcement">Informasi </label>
                                    <textarea id="announcement" name="announcement" class="form-control" rows="3">{{ $announcement->tool2 }}</textarea>
                                    <small>*informasi akan ditampilkan di bagian topbar</small>
                                </div>
                            </div>

                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Halaman Awal</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputEstimatedBudget">Background Banner</label><br>
                                    @if ($bannerHome->tool1 != null)
                                        <img src="{{ asset('/data/setting/' . $bannerHome->tool1) }}" width="100"
                                            alt="Logo">
                                    @else
                                        <img src="{{ asset('/data/setting/no-image.png') }}" width="100" alt="Logo">
                                    @endif
                                    <input type="hidden" name="banner_home_lama">
                                    <input type="file" id="inputEstimatedBudget" name="banner_home"
                                        class="form-control mt-3">
                                    <small>*Gunakan extensi .png agar logo lebih jelas</small>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEstimatedBudget">Gambar Slide 1</label><br>
                                    @if ($slide1->tool1 != null)
                                        <img src="{{ asset('/data/setting/' . $slide1->tool1) }}" width="100"
                                            alt="Logo">
                                    @else
                                        <img src="{{ asset('/data/setting/no-image.png') }}" width="100"
                                            alt="Logo">
                                    @endif
                                    <input type="hidden" name="slide_1_lama">
                                    <input type="file" id="inputEstimatedBudget" name="slide_1"
                                        class="form-control mt-3">
                                    <small>*Gunakan extensi .png agar logo lebih jelas</small>
                                </div>
                                <div class="form-group">
                                    <label for="title1">Judul</label>
                                    <input type="text" id="title1" name="title1" class="form-control"
                                        value="{{ $slide1->tool2 }}">
                                </div>
                                <div class="form-group">
                                    <label for="bank_rek">Isi</label>
                                    <textarea name="isi1" id="isi1" cols="30" rows="5" class="form-control">{{ $slide1->tool3 }}</textarea>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="inputEstimatedBudget">Gambar Slide 2</label><br>
                                    @if ($slide2->tool1 != null)
                                        <img src="{{ asset('/data/setting/' . $slide2->tool1) }}" width="100"
                                            alt="Logo">
                                    @else
                                        <img src="{{ asset('/data/setting/no-image.png') }}" width="100"
                                            alt="Logo">
                                    @endif
                                    <input type="hidden" name="slide_2_lama">
                                    <input type="file" id="inputEstimatedBudget" name="slide_2"
                                        class="form-control mt-3">
                                    <small>*Gunakan extensi .png agar logo lebih jelas</small>
                                </div>
                                <div class="form-group">
                                    <label for="title2">Judul</label>
                                    <input type="text" id="title2" name="title2" class="form-control"
                                        value="{{ $slide2->tool2 }}">
                                </div>
                                <div class="form-group">
                                    <label for="bank_rek">Isi</label>
                                    <textarea name="isi2" id="isi2" cols="30" rows="5" class="form-control">{{ $slide2->tool3 }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Upload</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputEstimatedBudget">Logo</label><br>
                                    @if ($storeLogo->tool1 != null)
                                        <img src="{{ asset('/data/setting/' . $storeLogo->tool1) }}" width="100"
                                            alt="Logo">
                                    @else
                                        <img src="{{ asset('/data/setting/no-image.png') }}" width="100"
                                            alt="Logo">
                                    @endif
                                    <input type="hidden" name="store_logo_lama">
                                    <input type="file" id="inputEstimatedBudget" name="store_logo"
                                        class="form-control mt-3">
                                    <small>*Gunakan extensi .png agar logo lebih jelas</small>
                                </div>
                                <div class="form-group">
                                    <label for="inputSpentBudget">Iklan </label> <br>
                                    @if ($advertisement->tool1 != null)
                                        <img src="{{ asset('/data/setting/' . $advertisement->tool1) }}" width="100"
                                            alt="Logo">
                                    @else
                                        <img src="{{ asset('/data/setting/no-image.png') }}" width="100"
                                            alt="Logo">
                                    @endif
                                    <input type="hidden" name="advertisement_lama">
                                    <input type="file" id="inputSpentBudget" name="advertisement"
                                        class="form-control mt-3">
                                    <small>*iklan akan ditampilkan di halaman kategori</small>
                                </div>
                                <div class="form-group">
                                    <label for="advertisement_link">Link Iklan</label>
                                    <input type="text" id="advertisement_link" name="advertisement_link"
                                        class="form-control" value="{{ $advertisement->tool2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Rekening Bank</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputEstimatedBudget">Logo Bank</label><br>
                                    @if ($bank->tool3 != null)
                                        <img src="{{ asset('/data/setting/' . $bank->tool3) }}" width="100"
                                            alt="Logo">
                                    @else
                                        <img src="{{ asset('/data/setting/no-image.png') }}" width="100"
                                            alt="Logo">
                                    @endif
                                    <input type="hidden" name="bank_logo_lama">
                                    <input type="file" id="inputEstimatedBudget" name="bank_logo"
                                        class="form-control mt-3">
                                    <small>*Gunakan extensi .png agar logo lebih jelas</small>
                                </div>
                                <div class="form-group">
                                    <label for="bank_name">Nama Bank</label>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control"
                                        value="{{ $bank->tool1 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="bank_rek">No Rekening</label>
                                    <input type="number" id="bank_rek" name="bank_rek" class="form-control"
                                        value="{{ $bank->tool2 }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="bank_rek_name">Atas Nama Bank</label>
                                    <input type="text" id="bank_rek_name" name="bank_rek_name" class="form-control"
                                        value="{{ $bank->tool4 }}" required>
                                </div>
                                <small>Harap diisi untuk form rekening bank karna digunakan untuk pembayaran
                                    customer</small>
                            </div>
                        </div>
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Sosial Media</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" id="facebook" name="facebook" class="form-control"
                                        placeholder="Masukkan Link Facebook" value="{{ $facebook->tool2 }}">
                                </div>
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" id="instagram" name="instagram" class="form-control"
                                        placeholder="Masukkan Link Instagram" value="{{ $instagram->tool2 }}">
                                </div>
                                <div class="form-group">
                                    <label>Sosial Media Lainnya</label>
                                    <input type="text" id="othersm" name="other_name" class="form-control"
                                        placeholder="Masukkan Nama Sosial Media" value="{{ $othersm->tool1 }}">
                                    <input type="text" id="othersm" name="other_link" class="form-control mt-2"
                                        placeholder="Masukkan Link.." value="{{ $othersm->tool2 }}">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('script')
    {{-- Select2 --}}
    <script src="{{ asset('/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@endpush
