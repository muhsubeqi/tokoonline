@extends('homepage.layouts.template')
@section('title')
    Register
@endsection
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row d-flex align-items-center flex-wrap">
                <div class="col-md-7">
                    <h1 class="h2">Register / Login</h1>
                </div>
                <div class="col-md-5">
                    <ul class="breadcrumb d-flex justify-content-end">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Register / Login</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="box">
                        <h2 class="text-uppercase">Register Akun</h2>
                        <p>Selamat datang sistem informasi kami! Untuk memulai penggunaan sistem, kami
                            sarankan Anda mendaftar akun terlebih dahulu. Dengan mendaftar, Anda dapat mengakses semua fitur
                            dan manfaat yang kami tawarkan.</p>
                        <p class="text-muted">Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi
                            kami, pusat layanan pelanggan kami bekerja untuk Anda 24/7.</p>
                        <hr>
                        <form action="{{ route('register.supplier-member.create') }}" method="post" id="form-register">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" name="username" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" class="form-control" required
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" name="password" type="password" class="form-control" required
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="phone">Telephone</label>
                                <input id="phone" name="phone" type="phone" class="form-control"
                                    autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="text" name="role" class="form-control" value="member" readonly>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-template-outlined" id="register-button"><i
                                        class="fa fa-user-md"></i>
                                    Register</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="box">
                        <h2 class="text-uppercase">Login</h2>
                        <p class="text-muted">Apakah anda sudah memiliki akun, jika sudah silahkan login menggunakan akun
                            anda</p>
                        <hr>
                        <form action="{{ route('login.supplier-member') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Log
                                    in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
