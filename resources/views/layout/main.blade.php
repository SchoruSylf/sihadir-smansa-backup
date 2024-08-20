<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>{{ $title ?? '' }} | SIHADIR</title>
    @yield('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    {{-- <link rel="shortcut icon" href="{{ asset('sihadir-s.jpg') }}"> --}}
    <link rel="shortcut icon" href="{{ asset('sihadir-s.ico') }}" type="image/jpeg">
    <!-- Sweet Alert 2-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-blue elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('user.dashboard') }}" class="brand-link">
                <img src="https://www.sman1ptk.sch.id/image/logo/sman1-pontianak-logo.png" alt="SMANSA Pontianak"
                    class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">SMANSA Pontianak</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="/user/profile" class="d-block">
                            {{ Session::get('name') }}
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (Session::get('role') == 1 || Session::get('role') == 2 || Session::get('role') == 3)
                            <li class="nav-item">
                                <a href="{{ route('user.dashboard') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            @if (Session::get('role') == 3)
                                <li class="nav-item">
                                    <a href="{{ route('user.presensi.siswa') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-check"></i>
                                        <p>
                                            Presensi
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.jadwal') }}" class="nav-link">
                                        <i class="nav-icon fas fa-calendar-alt"></i>
                                        <p>
                                            Jadwal
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.history.presensi') }}" class="nav-link">
                                        <i class="nav-icon fas fa-calendar-check"></i>
                                        <p>
                                            Riwayat Presensi
                                        </p>
                                    </a>
                                </li>
                            @elseif(Session::get('role') == 2)
                                <li class="nav-item">
                                    <a href="{{ route('user.presensi.guru') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-check"></i>
                                        <p>
                                            Presensi
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.jadwal') }}" class="nav-link">
                                        <i class="nav-icon fas fa-calendar-alt"></i>
                                        <p>
                                            Jadwal
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.history.presensi') }}" class="nav-link">
                                        <i class="nav-icon fas fa-calendar-check"></i>
                                        <p>
                                            Riwayat Presensi
                                        </p>
                                    </a>
                                </li>
                            @elseif (Session::get('role') == 1)
                                <li class="nav-item">
                                    <a href="{{ route('user.jadwal') }}" class="nav-link">
                                        <i class="nav-icon fas fa-calendar-alt"></i>
                                        <p>
                                            Jadwal
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.history.presensi') }}" class="nav-link">
                                        <i class="nav-icon fas fa-calendar-check"></i>
                                        <p>
                                            Riwayat Presensi
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                        <p>
                                            Konfigurasi Data
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href={{ route('user.user.read') }} class="nav-link">
                                                <i class="fas fa-user-cog"></i>
                                                <p>
                                                    Pengguna
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('user.kelas.read') }} class="nav-link">
                                                <i class="fas fa-chalkboard"></i>
                                                <p>
                                                    Kelas
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('user.mapel.read') }} class="nav-link">
                                                <i class="fas fa-book-open"></i>
                                                <p>Mata Pelajaran</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href={{ route('user.jadwal.read') }} class="nav-link">
                                                <i class="fas fa-calendar-day"></i>
                                                <p>Jadwal</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content-wrapper')
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    {{-- <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"
        integrity="sha512-mULnawDVcCnsk9a4aG1QLZZ6rcce/jSzEGqUkeOLy0b6q0+T6syHrxlsAGH7ZVoqC93Pd0lBqd6WguPWih7VHA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- Display SweetAlert2 if there is an error message -->
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
</body>

</html>
