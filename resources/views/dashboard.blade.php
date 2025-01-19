@extends('layout.main', ['title' => 'Dashboard'])
@section('css')
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
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
                                {{-- {{ $data_pengguna }} --}}
                                <h3 class="card-title">Data Presensi Kelas 10</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="kelas10"></canvas>
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
                                <canvas id="kelas11"></canvas>
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
                                <canvas id="kelas12"></canvas>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            @elseif(Session::get('role') == 2)
                <div class="row">
                    <div class="col-12 col-sm-6">
                        @if ($checkjadwal != null && count($checkjadwal) > 0)
                            <div class="card">
                                <div class="card-header">
                                    Mata pelajaran yang akan dilaksanakan pada {{ $dayName . ' - ' . $currentDate }}
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jam Pembelajaran</th>
                                                <th>Kelas</th>
                                                <th>Mata Pelajaran</th>
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($checkjadwal as $jadwal)
                                                <tr>
                                                    <td>{{ $jadwal->hari }}</td>
                                                    <td>{{ $jadwal->jam_mulai . ' - ' . $jadwal->jam_selesai }}</td>
                                                    <td>{{ $jadwal->kelas_name . ' ' . $jadwal->kelas_jenis }}</td>
                                                    <td>{{ $jadwal->mapel_name }}</td>
                                                    <td>
                                                        @if ($currentTime > $jadwal->jam_mulai && $currentTime < $jadwal->jam_selesai)
                                                            <a href="" class="btn btn-secondary disabled">Proses
                                                                KBM</a>
                                                        @elseif ($currentTime >= $jadwal->jam_mulai && $currentTime <= $jadwal->jam_selesai)
                                                            <a href="{{ route('user.presensi.guru') }}"
                                                                class="btn btn-primary">Mulai Kelas</a>
                                                        @elseif($currentTime < $jadwal->jam_mulai)
                                                            <a href="" class="btn btn-secondary disabled">Mulai
                                                                Kelas</a>
                                                        @else
                                                            <a href="" class="btn btn-secondary disabled"> Kelas
                                                                Selesai</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-header">
                                    Mata pelajaran pada {{ $dayName . ' - ' . $currentDate }}
                                    telah selesai
                                </div>
                                <div class="card-body">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="card">
                            <div class="card-header"> Riwayat Presensi Siswa</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tableHistory" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Hari</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Kelas</th>
                                                <th>Jumlah Jam Mata Pelajaran / 45 Menit</th>
                                                <th>Alpha</th>
                                                <th>Hadir</th>
                                                <th>Sakit</th>
                                                <th>Ijin</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(Session::get('role') == 3)
                <div class="row">
                    <div class="col-12 col-sm-6">
                        @if ($checkjadwaluser != null && count($checkjadwaluser) > 0)
                            <div class="card">
                                <div class="card-header">
                                    Mata pelajaran yang akan dilaksanakan pada {{ $dayName . ' - ' . $currentDate }}
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jam Pembelajaran</th>
                                                <th>Kelas</th>
                                                <th>Mata Pelajaran</th>
                                                <th>aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($checkjadwaluser as $jadwal)
                                                <tr>
                                                    <td>{{ $jadwal->hari }}</td>
                                                    <td>{{ $jadwal->jam_mulai . ' - ' . $jadwal->jam_selesai }}</td>
                                                    <td>{{ $jadwal->kelas_name . ' ' . $jadwal->kelas_jenis }}</td>
                                                    <td>{{ $jadwal->mapel_name }}</td>
                                                    <td>
                                                        @if ($currentTime > $jadwal->jam_mulai && $currentTime < $jadwal->jam_selesai)
                                                            <a href="" class="btn btn-secondary disabled">Proses
                                                                KBM</a>
                                                        @elseif ($currentTime >= $jadwal->jam_mulai && $currentTime <= $jadwal->jam_selesai)
                                                            <a href="{{ route('user.presensi.guru') }}"
                                                                class="btn btn-primary">Mulai Kelas</a>
                                                        @elseif($currentTime < $jadwal->jam_mulai)
                                                            <a href="" class="btn btn-secondary disabled">Mulai
                                                                Kelas</a>
                                                        @else
                                                            <a href="" class="btn btn-secondary disabled"> Kelas
                                                                Selesai</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-header">
                                    Mata pelajaran pada {{ $dayName . ' - ' . $currentDate }}
                                    telah selesai
                                </div>
                                <div class="card-body">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if ($message = Session::get('failed'))
        <script>
            Swal.fire('{{ $message }}');
        </script>
    @endif
    <script>
        $(document).ready(function() {
            loadData();
            loadChart();
        });

        function loadData() {
            $('#tableHistory').DataTable({
                searchDelay: 350,
                processing: true,
                paging: true,
                autoWidth: false,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                destroy: true,
                ajax: {
                    url: "{{ route('user.dashboard') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'hari',
                        name: 'hari'
                    },
                    {
                        data: 'kode_mapel',
                        name: 'kode_mapel'
                    },
                    {
                        data: 'kelas_jenis',
                        name: 'kelas_jenis'
                    },
                    {
                        data: 'total_jam',
                        name: 'total_jam'
                    },
                    {
                        data: 'alpha',
                        name: 'alpha'
                    },
                    {
                        data: 'hadir',
                        name: 'hadir'
                    },
                    {
                        data: 'sakit',
                        name: 'sakit'
                    },
                    {
                        data: 'ijin',
                        name: 'ijin'
                    },
                ],
                deferRender: true,
            });
        }
        let kelas10, kelas11, kelas12;

        function loadChart() {
            $.ajax({
                url: "{{ route('user.dashboard.admin') }}",
                // url: "{{ route('user.history.presensi.chart') }}",
                type: 'GET',
                success: function(response) {
                    // Data for Semester Chart
                    const kelas10Labels = [];
                    const kelas10AlphaData = [];
                    const kelas10HadirData = [];
                    const kelas10SakitData = [];
                    const kelas10IjinData = [];

                    response.kelas10.forEach(item => {
                        kelas10Labels.push(item.semester);
                        kelas10AlphaData.push(item.alpha);
                        kelas10HadirData.push(item.hadir);
                        kelas10SakitData.push(item.sakit);
                        kelas10IjinData.push(item.ijin);
                    });

                    const kelas11Labels = [];
                    const kelas11AlphaData = [];
                    const kelas11HadirData = [];
                    const kelas11SakitData = [];
                    const kelas11IjinData = [];

                    response.kelas11.forEach(item => {
                        kelas11Labels.push(item.month);
                        kelas11AlphaData.push(item.alpha);
                        kelas11HadirData.push(item.hadir);
                        kelas11SakitData.push(item.sakit);
                        kelas11IjinData.push(item.ijin);
                    });

                    const kelas12Labels = [];
                    const kelas12AlphaData = [];
                    const kelas12HadirData = [];
                    const kelas12SakitData = [];
                    const kelas12IjinData = [];

                    response.kelas12.forEach(item => {
                        kelas12Labels.push(item.day);
                        kelas12AlphaData.push(item.alpha);
                        kelas12HadirData.push(item.hadir);
                        kelas12SakitData.push(item.sakit);
                        kelas12IjinData.push(item.ijin);
                    });

                    const kelas10Ctx = document.getElementById('kelas10').getContext('2d');
                    const kelas11Ctx = document.getElementById('kelas11').getContext('2d');
                    const kelas12Ctx = document.getElementById('kelas12').getContext('2d');

                    if (kelas10) {
                        kelas10.destroy();
                    }

                    if (kelas11) {
                        kelas11.destroy();
                    }
                    
                    if (kelas12) {
                        kelas12.destroy();
                    }

                    kelas10 = new Chart(kelas10Ctx, {
                        type: 'line',
                        data: {
                            labels: kelas10Labels,
                            datasets: [{
                                label: 'Hadir',
                                data: kelas10HadirData,
                                backgroundColor: 'rgba(40, 167, 69, 0.2)', // Success (Light Green)
                                borderColor: 'rgba(40, 167, 69, 1)', // Success (Dark Green)
                                borderWidth: 3
                            }, {
                                label: 'Sakit',
                                data: kelas10SakitData,
                                backgroundColor: 'rgba(255, 193, 7, 0.2)', // Warning (Light Yellow)
                                borderColor: 'rgba(255, 193, 7, 1)', // Warning (Dark Yellow)
                                borderWidth: 3
                            }, {
                                label: 'Alpha',
                                data: kelas10AlphaData,
                                backgroundColor: 'rgba(220, 53, 69, 0.2)', // Danger (Light Red)
                                borderColor: 'rgba(220, 53, 69, 1)', // Danger (Dark Red)
                                borderWidth: 3
                            }, {
                                label: 'Ijin',
                                data: kelas10IjinData,
                                backgroundColor: 'rgba(23, 162, 184, 0.2)', // Info (Light Blue)
                                borderColor: 'rgba(23, 162, 184, 1)', // Info (Dark Blue)
                                borderWidth: 3
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                    kelas11 = new Chart(kelas11Ctx, {
                        type: 'line',
                        data: {
                            labels: kelas11Labels,
                            datasets: [{
                                label: 'Hadir',
                                data: kelas11HadirData,
                                backgroundColor: 'rgba(40, 167, 69, 0.2)', // Success (Light Green)
                                borderColor: 'rgba(40, 167, 69, 1)', // Success (Dark Green)
                                borderWidth: 3
                            }, {
                                label: 'Sakit',
                                data: kelas11SakitData,
                                backgroundColor: 'rgba(255, 193, 7, 0.2)', // Warning (Light Yellow)
                                borderColor: 'rgba(255, 193, 7, 1)', // Warning (Dark Yellow)
                                borderWidth: 3
                            }, {
                                label: 'Alpha',
                                data: kelas11AlphaData,
                                backgroundColor: 'rgba(220, 53, 69, 0.2)', // Danger (Light Red)
                                borderColor: 'rgba(220, 53, 69, 1)', // Danger (Dark Red)
                                borderWidth: 3
                            }, {
                                label: 'Ijin',
                                data: kelas11IjinData,
                                backgroundColor: 'rgba(23, 162, 184, 0.2)', // Info (Light Blue)
                                borderColor: 'rgba(23, 162, 184, 1)', // Info (Dark Blue)
                                borderWidth: 3
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                    kelas12= new Chart(kelas12Ctx, {
                        type: 'line',
                        data: {
                            labels: kelas12Labels,
                            datasets: [{
                                label: 'Hadir',
                                data: kelas12HadirData,
                                backgroundColor: 'rgba(40, 167, 69, 0.2)', // Success (Light Green)
                                borderColor: 'rgba(40, 167, 69, 1)', // Success (Dark Green)
                                borderWidth: 3
                            }, {
                                label: 'Sakit',
                                data: kelas12SakitData,
                                backgroundColor: 'rgba(255, 193, 7, 0.2)', // Warning (Light Yellow)
                                borderColor: 'rgba(255, 193, 7, 1)', // Warning (Dark Yellow)
                                borderWidth: 3
                            }, {
                                label: 'Alpha',
                                data: kelas12AlphaData,
                                backgroundColor: 'rgba(220, 53, 69, 0.2)', // Danger (Light Red)
                                borderColor: 'rgba(220, 53, 69, 1)', // Danger (Dark Red)
                                borderWidth: 3
                            }, {
                                label: 'Ijin',
                                data: kelas12IjinData,
                                backgroundColor: 'rgba(23, 162, 184, 0.2)', // Info (Light Blue)
                                borderColor: 'rgba(23, 162, 184, 1)', // Info (Dark Blue)
                                borderWidth: 3
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection
