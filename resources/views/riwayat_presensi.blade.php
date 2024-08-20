@extends('layout.main', ['title' => 'Riwayat Presensi'])
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
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Presensi Kelas 10</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tableExport" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Kode Mata Pelajaran</th>
                                        <th>Kelas</th>
                                        <th>Jumlah Jam</th>

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
        });

        $(document).ready(function() {
            loadData();
        });

        function loadData() {
            $('#tableUser').DataTable({
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
                    url: "{{ route('user.user.read') }}",
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
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'total_jam',
                        name: 'total_jam'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
                deferRender: true,
            });
        }
    </script>
@endsection
