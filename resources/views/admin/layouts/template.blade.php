<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/admin/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Mycss -->
    <link rel="stylesheet" href="{{ asset('/admin/dist/css/mycss.css') }}">
    <style>
        .toast-content {
            display: flex !important;
            align-items: center !important;
        }
    </style>
    @stack('css')
</head>

<body class="sidebar-mini control-sidebar-slide-open layout-navbar-fixed layout-fixed theme-style" id="theme-style">
    <div class="wrapper">

        @php
            $logo = App\Models\Setting::where('setting', 'store_logo')->first();
        @endphp
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            @if ($logo->tool1 != null)
                <img class="animation__shake" src="{{ asset('/data/setting/' . $logo->tool1) }}" alt="Logo"
                    height="60" width="60">
            @else
                <img class="animation__shake" src="" alt="Logo" height="60" width="60">
            @endif
        </div>

        @include('admin.layouts.navbar')

        @include('admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @include('admin.layouts.footer')

        @include('admin.layouts.control-sidebar')
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- momen js -->
    <script src="{{ asset('/admin/plugins/moment/moment.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('/admin/dist/js/adminlte.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('/admin/dist/js/demo.js') }}"></script> --}}
    <!-- SweetAlert2 -->
    <script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- myscript -->
    <script src="{{ asset('/admin/dist/js/myscript.js') }}"></script>
    @stack('script')

    <script>
        function logout(event) {
            event.preventDefault();
            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Kamu akan keluar dari sistem",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "OK!",
            }).then((result) => {
                if (result.value === true) {
                    document.getElementById("logout-form").submit();
                }
            });
        }
    </script>
    <script>
        const modeToggle = document.getElementById('mode-toggle');
        const themeStyle = document.getElementById('theme-style');
        const navbar = document.getElementById('navbar-style');
        const iconLight = document.getElementById('icon-light');
        const iconDark = document.getElementById('icon-dark');

        // Load the saved mode from cookie or default to 'light'
        const savedMode = getCookie('themeMode') || 'light';
        setTheme(savedMode);

        // Function to toggle between dark and light modes
        function toggleMode() {
            const currentMode = themeStyle.dataset.mode;
            const newMode = currentMode === 'dark' ? 'light' : 'dark';
            setTheme(newMode);
            setCookie('themeMode', newMode, 90); // Set the cookie for 90 days
        }

        // Function to apply the selected theme
        function setTheme(mode) {
            themeStyle.dataset.mode = mode;
            document.body.className =
                `${mode}-mode sidebar-mini layout-navbar-fixed layout-fixed`;

            if (mode === 'dark') {
                navbar.classList.add('navbar-dark');
                navbar.classList.remove('navbar-light');
            } else {
                navbar.classList.add('navbar-light');
                navbar.classList.remove('navbar-dark');
            }

            // Toggle icon visibility based on the mode
            if (mode === 'dark') {
                iconLight.style.display = 'inline';
                iconDark.style.display = 'none';
            } else {
                iconLight.style.display = 'none';
                iconDark.style.display = 'inline';
            }
        }

        // Function to get a cookie value by name
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Function to set a cookie
        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 24 * 60 * 60 * 1000).toUTCString();
            document.cookie = `${name}=${value}; expires=${expires}; path=/`;
        }

        // Attach event listener to the mode toggle button
        modeToggle.addEventListener('click', toggleMode);
    </script>

</body>

</html>
