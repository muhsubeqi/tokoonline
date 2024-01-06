@extends('homepage.layouts.template')
@section('title')
    My Account
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">My Account</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">My Account</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row bar mb-0">
                <div id="customer-orders" class="col-md-9">
                    @php
                        $storePhone = App\Models\Setting::where('setting', 'store_phone')->first();
                        $phone = substr($storePhone->tool1, 1);
                    @endphp
                    <p class="lead text-muted">Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami, pusat
                        layanan pelanggan kami bekerja untuk Anda 24 jam.
                        <a href="https://wa.me/62{{ @$phone }}" class="btn btn-success" target="_blank"><i
                                class="fa fa-whatsapp">
                                WhatsApp</i></a>
                    </p>
                    <div class="box mt-0 mb-lg-0">
                        <div class="bo3">
                            <form action="{{ route('myaccount.update', ['id' => auth()->user()->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name" name="name" type="text" class="form-control"
                                                value="{{ auth()->user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input id="username" name="username" type="text" class="form-control"
                                                value="{{ auth()->user()->username }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" name="email" type="text" class="form-control"
                                                value="{{ auth()->user()->email }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input id="phone" name="phone" type="number" class="form-control"
                                                value="{{ auth()->user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gender">Jenis Kelamin</label>
                                            <select class="form-control" name="gender" id="gender">
                                                @php
                                                    $gender = App\Services\BulkData::gender;
                                                @endphp
                                                @foreach ($gender as $g)
                                                    @if (auth()->user()->gender == $g['alias'])
                                                        <option value="{{ $g['alias'] }}" selected>{{ $g['name'] }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $g['alias'] }}">{{ $g['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="birthday">Tanggal Lahir</label>
                                            <input id="birthday" name="birthday" type="date" class="form-control"
                                                value="{{ auth()->user()->birthday }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center">
                                        <div class="form-group">
                                            @if (auth()->user()->image != null)
                                                <img src="{{ asset('data/user/' . auth()->user()->image) }}" width="150"
                                                    alt="Foto">
                                            @else
                                                <img src="{{ asset('/admin/dist/img/avatar5.png') }}" width="150"
                                                    alt="Foto">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="gender">Unggah Foto</label>
                                            <input type="hidden" name="image_old" value="{{ auth()->user()->image }}">
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password">Ganti Password</label>
                                            <input id="password" name="password" type="password" class="form-control">
                                            <small>*Kosongkan jika tidak ingin mengubah password</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-template-outlined"><i class="fa fa-save"></i>
                                        Save changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-4 mt-md-0">
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
                </div>
            </div>
        </div>
    </div>
@endsection
