@extends('layout.main', ['title' => 'Input Siswa'])
@section('css')
    <link rel="stylesheet" href="https:/cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Siswa ke Kelas {{ $userKelas->kelas }} {{ $userKelas->jenis_kelas }} </h1>
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
                        <i class="fas fa-user-plus"></i> Tambah Siswa</a>
                    <div class="modal fade" id="modal-input">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Input Data Kelas Siswa</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form Input -->
                                    <form action="{{ route('user.kelas.input_user', ['id_kelas' => $userKelas->id]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="">Nama Siswa</label>
                                                <select class="select2" multiple="multiple" style="width: 100%;">
                                                </select>
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
                    <!-- /.modal --><a href="" class="btn btn-primary mb-3" data-toggle="modal"
                        data-target="#modal-input-mass">
                        <i class="fas fa-users"></i> Tambah Siswa Menggunakan file XLSX</a>
                    <div class="modal fade" id="modal-input-mass">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Input Siswa kelas {{ $userKelas->kelas }}
                                        {{ $userKelas->jenis_kelas }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form Input -->
                                    <a class="btn btn-warning ml-3" href="{{ route('user.kelas.user_export') }}">
                                        Contoh Format file .xlsx
                                    </a>
                                    <form action="{{ route('user.kelas.input.mass', ['id_kelas' => $userKelas->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputFile">File input</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="exampleInputFile" name="filexlsx">
                                                        <label class="custom-file-label" for="exampleInputFile">Pilih file
                                                            data siswa kelas ini</label>
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
                </div>
                <!-- Display Data -->
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-body">
                            <!--Semua -->
                            <div class="table-responsive p-2">
                                <table id="tableUserkelas" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nomor Induk</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($User as $item)
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="modal-kelas-delete-user{{ $item->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modal-deleteLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Konfirmasi Hapus Siswa</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah anda yakin ingin menghapus Siswa di
                                                                <b> {{ $userKelas->kelas }}
                                                                    {{ $userKelas->jenis_kelas }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content">
                                                            <form
                                                                action="{{ route('user.kelas.delete_user', ['id_kelas' => $userKelas->id, 'id_userKelas' => $item->id]) }}"
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
    <!-- Select2 -->
    <script src="{{ asset('lte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
            loadData();
            loadSelect();
        });

        function loadData() {
            var table = $('#tableUserkelas').DataTable({
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
                    url: "{{ route('user.kelas.read_user', ['id_kelas' => $userKelas->id]) }}",
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
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                deferRender: true
            });
        }

        function loadSelect() {
            $('.select2').select2({
                placeholder: 'Cari Berdasarkan NISN atau Nama Siswa',
                ajax: {
                    url: "{{ route('user.kelas.read_selector_user', ['id_kelas' => $userKelas->id]) }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: '( ' + item.nomor_induk + ' ) ' + item.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            }).attr('name', 'students[]'); // Add name attribute for form submission
        }
    </script>
@endsection
