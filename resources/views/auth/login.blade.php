<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('/admin/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/admin/dist/css/adminlte.min.css?v=3.2.0') }}">

    @php
        $banner = App\Models\Setting::where('setting', 'banner_home')->first();
    @endphp
    <style>
        .login-page {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.6)),
                url('/data/setting/{{ @$banner->tool1 }}');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .login-logo a {
            color: #fff !important;
            font-weight: 600;
        }

        .login-card-body {
            background-color: rgba(0, 0, 0, 0.1);
        }
    </style>

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        @php
            $storeName = App\Models\Setting::where('setting', 'store_name')->first();
            $storeLogo = App\Models\Setting::where('setting', 'store_logo')->first();
        @endphp
        <div class="login-logo">
            <a href="{{ route('home') }}"><b>{{ $storeName->tool1 }}</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <img src="{{ asset('data/setting/' . @$storeLogo->tool1) }}" class="d-flex m-auto" width="100"
                    alt="">
                <p class="login-box-msg mt-3">Sign in to admin dashboard</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>

                    </div>
                </form>

                @if (Route::has('password.request'))
                    <p class="mb-1">
                        <a href="{{ route('password.request') }}">I forgot my password</a>
                    </p>
                @endif
            </div>

        </div>
    </div>

    <script src="{{ asset('/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/admin/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
</body>

</html>
