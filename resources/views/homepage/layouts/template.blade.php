<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('/homepage/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('/homepage/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Google fonts - Roboto-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
    <!-- Bootstrap Select-->
    <link rel="stylesheet" href="{{ asset('/homepage/vendor/bootstrap-select/css/bootstrap-select.min.css') }}">
    <!-- owl carousel-->
    <link rel="stylesheet" href="{{ asset('/homepage/vendor/owl.carousel/assets/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('/homepage/vendor/owl.carousel/assets/owl.theme.default.css') }}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('/homepage/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('/homepage/css/custom.css') }}">
    <!-- Favicon and apple touch icons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-touch-icon-152x152.png">

    {{-- Sweet Alert --}}
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body>
    <div id="all">
        <!-- Top bar-->
        @include('homepage.layouts.topbar')
        <!-- Top bar end-->
        <!-- Login Modal-->
        @include('homepage.layouts.login-modal')
        <!-- Login modal end-->
        <!-- Navbar Start-->
        @include('homepage.layouts.navbar')
        <!-- Navbar End-->

        @yield('content')
        <!-- FOOTER -->
        @include('homepage.layouts.footer')

    </div>
    <!-- Javascript files-->
    <script src="{{ asset('/homepage/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/popper.js/umd/popper.min.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/jquery.cookie/jquery.cookie.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') }}"></script>
    <script src="{{ asset('/homepage/js/jquery.parallax-1.1.3.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/homepage/vendor/jquery.scrollto/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('/homepage/js/front.js') }}"></script>
    {{-- Sweet Alert --}}
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    @stack('script')

    <script>
        @if (Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{!! Session::get('error') !!}",
                timer: 5000
            })
        @endif
        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{!! Session::get('success') !!}",
                timer: 5000
            })
        @endif
        @if (Session::has('success-email'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{!! Session::get('success-email') !!}"
            })
        @endif
    </script>
</body>

</html>
