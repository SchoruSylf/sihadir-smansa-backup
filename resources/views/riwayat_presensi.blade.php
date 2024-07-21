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
                                        <th></th>
                                        <th>Jumlah Jam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $id)
                                        <tr>
                                            <td>{{ $id->name }}</td>
                                            <td>{{ $id->email }}</td>
                                            {{-- <td>{{ $id->password }}</td> --}}
                                        </tr>
                                    @endforeach
                                    </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <script>
        $(function() {
            $("#tableExport").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
