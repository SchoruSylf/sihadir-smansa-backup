@extends('layout.main', ['title' => 'Riwayat Presensi'])

@section('css')
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
                        <h1>Riwayat Presensi</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Riwayat Presensi Setiap Semester</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="semester"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Riwayat Presensi Setiap Bulan</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="bulan"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Session::get('role') == 1 || Session::get('role') == 2)
                        <div class="card">
                            <div class="card-body">
                                <a class="btn btn-warning mb-3" href="{{ route('user.history.detail.export') }}">
                                    Export Riwayat Presensi
                                </a>
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
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    url: "{{ route('user.history.presensi') }}",
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
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                deferRender: true,
            });
        }

        let semester, bulan;

        function loadChart() {
            $.ajax({
                url: "{{ route('user.history.presensi.chart') }}",
                type: 'GET',
                success: function(response) {
                    // Data for Semester Chart
                    const semesterLabels = [];
                    const semesterAlphaData = [];
                    const semesterHadirData = [];
                    const semesterSakitData = [];
                    const semesterIjinData = [];

                    response.semester.forEach(item => {
                        semesterLabels.push(item.semester);
                        semesterAlphaData.push(item.alpha);
                        semesterHadirData.push(item.hadir);
                        semesterSakitData.push(item.sakit);
                        semesterIjinData.push(item.ijin);
                    });

                    const monthLabels = [];
                    const monthAlphaData = [];
                    const monthHadirData = [];
                    const monthSakitData = [];
                    const monthIjinData = [];

                    response.month.forEach(item => {
                        monthLabels.push(item.month);
                        monthAlphaData.push(item.alpha);
                        monthHadirData.push(item.hadir);
                        monthSakitData.push(item.sakit);
                        monthIjinData.push(item.ijin);
                    });

                    const semesterCtx = document.getElementById('semester').getContext('2d');
                    const bulanCtx = document.getElementById('bulan').getContext('2d');

                    if (semester) {
                        semester.destroy();
                    }

                    if (bulan) {
                        bulan.destroy();
                    }

                    semester = new Chart(semesterCtx, {
                        type: 'line',
                        data: {
                            labels: semesterLabels,
                            datasets: [{
                                label: 'Hadir',
                                data: semesterHadirData,
                                backgroundColor: 'rgba(40, 167, 69, 0.2)', // Success (Light Green)
                                borderColor: 'rgba(40, 167, 69, 1)', // Success (Dark Green)
                                borderWidth: 3
                            }, {
                                label: 'Sakit',
                                data: semesterSakitData,
                                backgroundColor: 'rgba(255, 193, 7, 0.2)', // Warning (Light Yellow)
                                borderColor: 'rgba(255, 193, 7, 1)', // Warning (Dark Yellow)
                                borderWidth: 3
                            }, {
                                label: 'Alpha',
                                data: semesterAlphaData,
                                backgroundColor: 'rgba(220, 53, 69, 0.2)', // Danger (Light Red)
                                borderColor: 'rgba(220, 53, 69, 1)', // Danger (Dark Red)
                                borderWidth: 3
                            }, {
                                label: 'Ijin',
                                data: semesterIjinData,
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

                    bulan = new Chart(bulanCtx, {
                        type: 'line',
                        data: {
                            labels: monthLabels,
                            datasets: [{
                                label: 'Hadir',
                                data: monthHadirData,
                                backgroundColor: 'rgba(40, 167, 69, 0.2)', // Success (Light Green)
                                borderColor: 'rgba(40, 167, 69, 1)', // Success (Dark Green)
                                borderWidth: 3
                            }, {
                                label: 'Sakit',
                                data: monthSakitData,
                                backgroundColor: 'rgba(255, 193, 7, 0.2)', // Warning (Light Yellow)
                                borderColor: 'rgba(255, 193, 7, 1)', // Warning (Dark Yellow)
                                borderWidth: 3
                            }, {
                                label: 'Alpha',
                                data: monthAlphaData,
                                backgroundColor: 'rgba(220, 53, 69, 0.2)', // Danger (Light Red)
                                borderColor: 'rgba(220, 53, 69, 1)', // Danger (Dark Red)
                                borderWidth: 3
                            }, {
                                label: 'Ijin',
                                data: monthIjinData,
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
