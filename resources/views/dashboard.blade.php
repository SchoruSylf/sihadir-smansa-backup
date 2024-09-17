@extends('layout.main', ['title' => 'Dashboard'])
@section('css')
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        {{-- @dd(Session::all()) --}}
        <!-- Main content -->
        <section class="content">
            @if (Session::get('role') == 1)
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <!-- BAR CHART Kelas 10-->
                        <div class="card card-warning">
                            <div class="card-header">
                                {{ $data_pengguna }}
                                <h3 class="card-title">Data Presensi Kelas 10</h3>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- BAR CHART Kelas 11-->
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Data Presensi Kelas 11</h3>

                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- BAR CHART Kelas 12-->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Data Presensi Kelas 12</h3>

                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            @elseif(Session::get('role') == 2)
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                hari / tanggal
                            </div>
                            <div class="card-body">
                                <table></table>
                            </div>
                            <div class="card-footer">
                                tombol pindah halaman presensi
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                header
                            </div>
                            <div class="card-body">
                                body
                            </div>
                            <div class="card-footer">
                                footer
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(Session::get('role') == 3)
                Siswa
            @endif
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    @if ($message = Session::get('failed'))
        <script>
            Swal.fire('{{ $message }}');
        </script>
    @endif
@endsection
