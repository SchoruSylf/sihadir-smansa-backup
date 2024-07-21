@extends('layout.main', ['title' => 'Jadwal'])
@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jadwal</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12  ">
                    <div class="card card-primary card-tabs">
                        <div class="card-title p-2">
                            Kelas 10
                        </div>
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs space-between" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="jadwal-kelas-10-A-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-A" role="tab" aria-controls="jadwal-kelas-10-A"
                                        aria-selected="true">A</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-B-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-B" role="tab" aria-controls="jadwal-kelas-10-B"
                                        aria-selected="false">B</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-C-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-C" role="tab" aria-controls="jadwal-kelas-10-C"
                                        aria-selected="false">C</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-D-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-D" role="tab" aria-controls="jadwal-kelas-10-D"
                                        aria-selected="false">D</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-E-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-E" role="tab" aria-controls="jadwal-kelas-10-E"
                                        aria-selected="false">E</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-F-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-F" role="tab" aria-controls="jadwal-kelas-10-F"
                                        aria-selected="false">F</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-G-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-G" role="tab" aria-controls="jadwal-kelas-10-G"
                                        aria-selected="false">G</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-H-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-H" role="tab" aria-controls="jadwal-kelas-10-H"
                                        aria-selected="false">H</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-I-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-I" role="tab" aria-controls="jadwal-kelas-10-I"
                                        aria-selected="false">I</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-J-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-J" role="tab" aria-controls="jadwal-kelas-10-J"
                                        aria-selected="false">J</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-K-tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-K" role="tab" aria-controls="jadwal-kelas-10-K"
                                        aria-selected="false">K</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-10-L=tab" data-toggle="pill"
                                        href="#jadwal-kelas-10-L" role="tab" aria-controls="jadwal-kelas-10-L"
                                        aria-selected="false">L</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="jadwal-kelas-10-A" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-A-tab">
                                    <table id="tableJadwal10A" class="table table-bordered table-striped">
                                        10a
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-B" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-B-tab">
                                    <table id="tableJadwal10B" class="table table-bordered table-striped">
                                        10b
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-C" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-C-tab">
                                    <table id="tableJadwal10C" class="table table-bordered table-striped">
                                        10c
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-D" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-D-tab">
                                    <table id="tableJadwal10D" class="table table-bordered table-striped">
                                        10d
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-E" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-E-tab">
                                    <table id="tableJadwal10E" class="table table-bordered table-striped">
                                        10e
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-F" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-F-tab">
                                    <table id="tableJadwal10F" class="table table-bordered table-striped">
                                        10f
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-G" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-G-tab">
                                    <table id="tableJadwal10G" class="table table-bordered table-striped">
                                        10g
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-H" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-H-tab">
                                    <table id="tableJadwal10H" class="table table-bordered table-striped">
                                        10h
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-I" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-I-tab">
                                    <table id="tableJadwal10I" class="table table-bordered table-striped">
                                        10i
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-J" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-J-tab">
                                    <table id="tableJadwal10J" class="table table-bordered table-striped">
                                        10j
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-K" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-K-tab">
                                    <table id="tableJadwal10K" class="table table-bordered table-striped">
                                        10k
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-10-L" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-10-L-tab">
                                    <table id="tableJadwal10L" class="table table-bordered table-striped">
                                        10l
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12  ">
                    <div class="card card-primary card-tabs">
                        <div class="card-title p-2">
                            Kelas 11
                        </div>
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs space-between" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="jadwal-kelas-11-A-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-A" role="tab" aria-controls="jadwal-kelas-11-A"
                                        aria-selected="true">A</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-B-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-B" role="tab" aria-controls="jadwal-kelas-11-B"
                                        aria-selected="false">B</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-C-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-C" role="tab" aria-controls="jadwal-kelas-11-C"
                                        aria-selected="false">C</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-D-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-D" role="tab" aria-controls="jadwal-kelas-11-D"
                                        aria-selected="false">D</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-E-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-E" role="tab" aria-controls="jadwal-kelas-11-E"
                                        aria-selected="false">E</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-F-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-F" role="tab" aria-controls="jadwal-kelas-11-F"
                                        aria-selected="false">F</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-G-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-G" role="tab" aria-controls="jadwal-kelas-11-G"
                                        aria-selected="false">G</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-H-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-H" role="tab" aria-controls="jadwal-kelas-11-H"
                                        aria-selected="false">H</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-I-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-I" role="tab" aria-controls="jadwal-kelas-11-I"
                                        aria-selected="false">I</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-J-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-J" role="tab" aria-controls="jadwal-kelas-11-J"
                                        aria-selected="false">J</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-K-tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-K" role="tab" aria-controls="jadwal-kelas-11-K"
                                        aria-selected="false">K</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-11-L=tab" data-toggle="pill"
                                        href="#jadwal-kelas-11-L" role="tab" aria-controls="jadwal-kelas-11-L"
                                        aria-selected="false">L</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="jadwal-kelas-11-A" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-A-tab">
                                    <table id="tableJadwal11A" class="table table-bordered table-striped">
                                        11a
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-B" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-B-tab">
                                    <table id="tableJadwal11B" class="table table-bordered table-striped">
                                        11b
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-C" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-C-tab">
                                    <table id="tableJadwal11C" class="table table-bordered table-striped">
                                        11c
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-D" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-D-tab">
                                    <table id="tableJadwal11D" class="table table-bordered table-striped">
                                        11d
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-E" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-E-tab">
                                    <table id="tableJadwal11E" class="table table-bordered table-striped">
                                        11e
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-F" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-F-tab">
                                    <table id="tableJadwal11F" class="table table-bordered table-striped">
                                        11f
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-G" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-G-tab">
                                    <table id="tableJadwal11G" class="table table-bordered table-striped">
                                        11g
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-H" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-H-tab">
                                    <table id="tableJadwal11H" class="table table-bordered table-striped">
                                        11h
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-I" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-I-tab">
                                    <table id="tableJadwal11I" class="table table-bordered table-striped">
                                        11i
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-J" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-J-tab">
                                    <table id="tableJadwal11J" class="table table-bordered table-striped">
                                        11j
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-K" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-K-tab">
                                    <table id="tableJadwal11K" class="table table-bordered table-striped">
                                        11k
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-11-L" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-11-L-tab">
                                    <table id="tableJadwal11L" class="table table-bordered table-striped">
                                        11l
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12  ">
                    <div class="card card-primary card-tabs">
                        <div class="card-title p-2">
                            Kelas 12
                        </div>
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs space-between" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="jadwal-kelas-12-A-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-A" role="tab" aria-controls="jadwal-kelas-12-A"
                                        aria-selected="true">A</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-B-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-B" role="tab" aria-controls="jadwal-kelas-12-B"
                                        aria-selected="false">B</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-C-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-C" role="tab" aria-controls="jadwal-kelas-12-C"
                                        aria-selected="false">C</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-D-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-D" role="tab" aria-controls="jadwal-kelas-12-D"
                                        aria-selected="false">D</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-E-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-E" role="tab" aria-controls="jadwal-kelas-12-E"
                                        aria-selected="false">E</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-F-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-F" role="tab" aria-controls="jadwal-kelas-12-F"
                                        aria-selected="false">F</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-G-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-G" role="tab" aria-controls="jadwal-kelas-12-G"
                                        aria-selected="false">G</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-H-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-H" role="tab" aria-controls="jadwal-kelas-12-H"
                                        aria-selected="false">H</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-I-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-I" role="tab" aria-controls="jadwal-kelas-12-I"
                                        aria-selected="false">I</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-J-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-J" role="tab" aria-controls="jadwal-kelas-12-J"
                                        aria-selected="false">J</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-K-tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-K" role="tab" aria-controls="jadwal-kelas-12-K"
                                        aria-selected="false">K</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jadwal-kelas-12-L=tab" data-toggle="pill"
                                        href="#jadwal-kelas-12-L" role="tab" aria-controls="jadwal-kelas-12-L"
                                        aria-selected="false">L</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="jadwal-kelas-12-A" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-A-tab">
                                    <table id="tableJadwal12A" class="table table-bordered table-striped">
                                        12a
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-B" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-B-tab">
                                    <table id="tableJadwal12B" class="table table-bordered table-striped">
                                        12b
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-C" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-C-tab">
                                    <table id="tableJadwal12C" class="table table-bordered table-striped">
                                        12c
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-D" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-D-tab">
                                    <table id="tableJadwal12D" class="table table-bordered table-striped">
                                        12d
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-E" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-E-tab">
                                    <table id="tableJadwal12E" class="table table-bordered table-striped">
                                        12e
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-F" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-F-tab">
                                    <table id="tableJadwal12F" class="table table-bordered table-striped">
                                        12f
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-G" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-G-tab">
                                    <table id="tableJadwal12G" class="table table-bordered table-striped">
                                        12g
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-H" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-H-tab">
                                    <table id="tableJadwal12H" class="table table-bordered table-striped">
                                        12h
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-I" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-I-tab">
                                    <table id="tableJadwal12I" class="table table-bordered table-striped">
                                        12i
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-J" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-J-tab">
                                    <table id="tableJadwal12J" class="table table-bordered table-striped">
                                        12j
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-K" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-K-tab">
                                    <table id="tableJadwal12K" class="table table-bordered table-striped">
                                        12k
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="jadwal-kelas-12-L" role="tabpanel"
                                    aria-labelledby="jadwal-kelas-12-L-tab">
                                    <table id="tableJadwal12L" class="table table-bordered table-striped">
                                        12l
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Jumlah Waktu</th>
                                                <th>Kode Mata Pelajaran</th>
                                                <th>Nama Mata Pelajaran</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
