@extends('layout.main', ['title' => 'Data Mata Pelajaran'])
@section('css')
    <link rel="stylesheet" href="https:/cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
@endsection
@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Mata Pelajaran</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <!-- table data -->
                    <div class="card card-primary">
                        <div class="table-responsive p-2">
                            <table id="tableMapel" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Mata Pelajaran</th>
                                        <th>Nama Mata Pelajaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapels as $mapel)
                                        {{-- @dd($mapels); --}}
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="modal-update-mapel{{ $mapel->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-update-mapelLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data Mata Pelajaran</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- form Update -->
                                                        <form
                                                            action="{{ route('user.mapel.update', ['id_mapel' => $mapel->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label>Kode Mata Pelajaran</label>
                                                                    <input type="text" name="kode_mapel"
                                                                        class="form-control"
                                                                        placeholder="Kode atau Alias pada setiap mata pelajaran"
                                                                        pattern="[a-zA-Z]{2,4}"
                                                                        value={{ $mapel->kode_mapel }}>
                                                                </div>
                                                                @error('kode_mapel')
                                                                    <small style="color: red">{{ $message }}</small>
                                                                @enderror
                                                                <div class="form-group">
                                                                    <label>Nama Mata Pelajaran</label>
                                                                    <input type="text" name="nama_mapel"
                                                                        class="form-control"
                                                                        placeholder="Informatika / PPkn / Matematika / A / B"
                                                                        value={{ $mapel->nama_mapel }}>
                                                                </div>
                                                                @error('nama_mapel')
                                                                    <small style="color: red">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                            <!-- /.card-body -->
                                                            <div class="modal-footer justify-content">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="modal-delete-mapel{{ $mapel->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-delete-mapelLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Konfirmasi Hapus Mata Pelajaran</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin ingin menghapus Mata Pelajaran
                                                            <b>( {{ $mapel->kode_mapel }} )</b>
                                                            <b> {{ $mapel->nama_mapel }}</b>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content">
                                                        <form
                                                            action="{{ route('user.mapel.delete', ['id_mapel' => $mapel->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <!-- Form Tambah Mata Pelajaran -->
                    <div class="card card-primary ">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Mata Pelajaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('user.mapel.input') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Kode Mata Pelajaran</label>
                                    <input type="text" name="kode_mapel" class="form-control"
                                        placeholder="Kode atau Alias pada setiap mata pelajaran" pattern="[a-zA-Z]{2,4}">
                                </div>
                                @error('kode_mapel')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                                <div class="form-group">
                                    <label>Nama Mata Pelajaran</label>
                                    <input type="text" name="nama_mapel" class="form-control"
                                        placeholder="Informatika / PPkn / Matematika">
                                </div>
                                @error('nama_mapel')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            loadData();
        });

        function loadData() {
            $('#tableMapel').DataTable({
                searchDelay: 350,
                lengthChange: false,
                autoWidth: false,
                paging: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                destroy: true,
                ajax: {
                    url: "{{ route('user.mapel.read') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'kode_mapel',
                        name: 'kode_mapel',
                        searchable: true,
                        orderable: true,
                    },
                    {
                        data: 'nama_mapel',
                        name: 'nama_mapel',
                        searchable: true,
                        orderable: true,
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
    </script>
@endsection
