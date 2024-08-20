@extends('layout.main', ['title' => 'Data Pengguna'])
@section('css')
    <link rel="stylesheet" href="https:/cdn.datatables.net/1.13.4/css/jquery.dataTables.css">

    <!-- DataTables -->
    {{-- <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> --}}
@endsection
@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Pengguna</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Tambah Pengguna  -->
                <div class="col-12">
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-input">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna</a>
                    <div class="modal fade" id="modal-input">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Input Data Pengguna</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form Input -->
                                    <form action="{{ route('user.user.input') }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Nomor Induk</label>
                                                <input type="text" inputmode="numeric" name="nomor_induk" i
                                                    class="form-control" placeholder="NISN / NIP / NIK">
                                            </div>
                                            @error('nomor_induk')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                            <div class="form-group">
                                                <label for="">Nama</label>
                                                <input type="text" inputmode="numeric" name="name"
                                                    class="form-control" placeholder="Nama Lengkap">
                                            </div>
                                            @error('name')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                            <div class="form-group">
                                                <label>Role</label>
                                                <select name="role" class="form-control">
                                                    <option value="3">3 (Siswa)</option>
                                                    <option value="2">2 (Guru)</option>
                                                    <option value="1">1 (Administrator)</option>
                                                </select>
                                            </div>
                                            @error('role')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Lulus">Lulus</option>
                                                    <option value="Pensiun">Pensiun</option>
                                                </select>
                                            </div>
                                            @error('status')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control">
                                                    <option value="L">Laki - laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                            @error('jenis_kelamin')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" inputmode="numeric" name="email"
                                                    class="form-control" placeholder="email">
                                            </div>
                                            @error('email')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Password">
                                            </div>
                                            @error('password')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="modal-footer justify-content">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-input-mass">
                        <i class="fas fa-users"></i> Tambah Pengguna Menggunakan file XLSX</a>
                    <div class="modal fade" id="modal-input-mass">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Input Data Pengguna</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form Input -->
                                    <a class="btn btn-warning ml-3" href="{{ route('user.user.exports') }}">
                                        Contoh Format file .xlsx
                                    </a>
                                    <form action="{{ route('user.user.input.mass') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputFile">File input</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="exampleInputFile" name="filexlsx">
                                                        <label class="custom-file-label" for="exampleInputFile">Pilih file
                                                            data pengguna</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <a class="btn btn-warning mb-3" href="{{ route('user.user.export') }}">
                        Export User Data
                    </a>
                </div>
                <!-- Display Data -->
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-body">
                            <!--Semua -->
                            <div class="table-responsive p-2">
                                <table id="tableUser" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nomor Induk</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach ($data as $item)
                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="modal-update-user{{ $item->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modal-update-userLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Data Pengguna</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- form Update -->
                                                            <form
                                                                action="{{ route('user.user.update', ['id_user' => $item->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Nomor
                                                                            Induk</label>
                                                                        <input type="text" inputmode="numeric"
                                                                            name="nomor_induk"
                                                                            value="{{ $item->nomor_induk }}"
                                                                            class="form-control" placeholder="NISN / NIS / NIP / NIK">
                                                                    </div>
                                                                    @error('nomor_induk')
                                                                        <small style="color: red">{{ $message }}</small>
                                                                    @enderror
                                                                    <div class="form-group">
                                                                        <label for="">Nama</label>
                                                                        <input value="{{ $item->name }}" type="text"
                                                                            inputmode="numeric" name="name"
                                                                            class="form-control"
                                                                            placeholder="Nama Lengkap">
                                                                    </div>
                                                                    @error('name')
                                                                        <small style="color: red">{{ $message }}</small>
                                                                    @enderror
                                                                    <div class="form-group">
                                                                        <label>Role</label>
                                                                        <select name="role" class="form-control">
                                                                            <option value="{{ $item->role }}">
                                                                                {{ $item->role }}
                                                                            </option>
                                                                            <option value="3">3 (Siswa)
                                                                            </option>
                                                                            <option value="2">2 (Guru)
                                                                            </option>
                                                                            <option value="1">1
                                                                                (Administrator)
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    @error('role')
                                                                        <small style="color: red">{{ $message }}</small>
                                                                    @enderror
                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select name="status" class="form-control">
                                                                            <option value="{{ $item->status }}">
                                                                                {{ $item->status }}
                                                                            </option>
                                                                            <option value="aktif">Aktif</option>
                                                                            <option value="lulus">Lulus</option>
                                                                            <option value="pensiun">Pensiun</option>
                                                                        </select>
                                                                    </div>
                                                                    @error('status')
                                                                        <small style="color: red">{{ $message }}</small>
                                                                    @enderror
                                                                    <div class="form-group"><label>Jenis Kelamin</label>
                                                                        <select name="jenis_kelamin" class="form-control">
                                                                            <option value="{{ $item->jenis_kelamin }}">
                                                                                {{ $item->jenis_kelamin }}</option>
                                                                            <option value="L">Laki-laki</option>
                                                                            <option value="P">Perempuan</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Email</label>
                                                                        <input type="email" inputmode="numeric"
                                                                            name="email" value="{{ $item->email }}"
                                                                            class="form-control" placeholder="email">
                                                                    </div>
                                                                    @error('email')
                                                                        <small style="color: red">{{ $message }}</small>
                                                                    @enderror
                                                                    <div class="form-group">
                                                                        <label for="exampleInputPassword1">Password</label>
                                                                        <input type="password" class="form-control"
                                                                            name="password" id="password"
                                                                            placeholder="Password">
                                                                    </div>
                                                                    @error('password')
                                                                        <small style="color: red">{{ $message }}</small>
                                                                    @enderror
                                                                </div>
                                                                <!-- /.card-body -->
                                                                <div class="modal-footer justify-content">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Edit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="modal-delete-user{{ $item->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modal-deleteLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Konfirmasi Hapus Pengguna</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah anda yakin ingin menghapus data pengguna
                                                                <b>{{ $item->name }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content">
                                                            <form
                                                                action="{{ route('user.user.delete', ['id_user' => $item->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
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
                        data: 'nomor_induk',
                        name: 'nomor_induk'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
