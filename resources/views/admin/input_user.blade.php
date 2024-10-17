@extends('layout.main', ['title' => 'Data Pengguna'])
@section('css')
    <link rel="stylesheet" href="https:/cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    {{-- <a href="" class="btn btn-primary mb-3" name="modalAdd" id="modalAdd">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna</a> --}}
                    <button type="button" name="modaladd" id="modalAdd" class="btn btn-primary mb-3"> <i
                            class="fas fa-user-plus"></i> Tambah Pengguna</button>
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-input-mass">
                        <i class="fas fa-users"></i> Tambah Pengguna Menggunakan file XLSX</a>
                    {{-- Modal Input mass --}}
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            {{-- MODAL INPUT & UPDATE --}}
            <div class="modal fade" id="formInputUpdate" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" enctype="multipart/form-data" id="formUser" class="form-horizontal">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalLabel">Input Data Pengguna</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- form Input -->
                                <span id="form_result"></span>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nomor Induk</label>
                                        <input type="text" inputmode="numeric" name="nomor_induk" id="nomor_induk"
                                            class="form-control" placeholder="NIS / NIK">
                                    </div>
                                    @error('nomor_induk')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" inputmode="numeric" name="name"
                                            id="name"class="form-control" placeholder="Nama Lengkap">
                                    </div>
                                    @error('name')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-control">
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
                                        <select name="status" id="status" class="form-control">
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
                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                            <option value="L">Laki - laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" inputmode="numeric" name="email" id="email"
                                            class="form-control" placeholder="email">
                                    </div>
                                    @error('email')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Password">
                                    </div>
                                    @error('password')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                            </div>
                            <div class="modal-footer justify-content">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <input type="submit" name="action_button" id="action_button" value="Tambah"
                                    class="btn btn-primary" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Delete Modal -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form method="POST" id="formUser" class="form-horizontal">
                            <div class="modal-header">
                                <h4 class="modal-title">Konfirmasi Hapus Pengguna</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin ingin menghapus data pengguna milik
                                <p id="namedelete" name="namedelete"></p>
                                </p>
                            </div>
                            <div class="modal-footer justify-content">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" name="ok_button" id="ok_button"
                                        class="btn btn-danger">OK</button>
                                </div>
                            </div>
                        </form>
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
    {{-- <script>
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
    </script> --}}

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
        $(document).ready(function() {
            $('#modalAdd').click(function() {
                $('.modal-title').text('Input Data Pengguna');
                $('#action_button').val('Tambah');
                $('#action').val('Tambah');
                $('#form_result').html('');
                $('#formUser')[0].reset();
                $('#formInputUpdate').modal('show');
            });

            $(document).on('click', '.edit', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                $('#form_result').html('');

                $.ajax({
                    url: "user/edit/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        // console.log('success: ' + data);
                        $('#nomor_induk').val(data.result.nomor_induk);
                        $('#name').val(data.result.name);
                        $('#role').val(data.result.role);
                        $('#status').val(data.result.status);
                        $('#jenis_kelamin').val(data.result.jenis_kelamin);
                        $('#password').val(data.result.password);
                        $('#email').val(data.result.email);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Record');
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formInputUpdate').modal('show');

                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function() {

                id = $(this).attr('id');
                $.ajax({
                    url: "user/edit/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#namedelete').text(data.result.name);
                        console.log($('#namedelete').val())
                        $('#confirmModal').modal('show');
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });

            $('#ok_button').click(function() {
                $.ajax({
                    url: "user/delete/" + user_id,
                    beforeSend: function() {
                        $('#ok_button').text('Deleting...');
                    },
                    success: function(data) {
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                            $('#tableUser').DataTable().ajax.reload();
                        }, 1000);
                    }
                })
            });
            loadData();
        });

        $('#formUser').on('submit', function(event) {
            event.preventDefault();
            var action_url = $('#action').val() == 'Tambah' ? "{{ route('user.user.input') }}" :
                "{{ route('user.user.update') }}"
            console.log($('#action').val() + " " + action_url);
            $.ajax({
                url: action_url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    // console.log($('#nomor_induk').val());
                    console.log('success: ' + data);
                    var html = '';
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (var count = 0; count < data.errors.length; count++) {
                            html += '<p>' + data.errors[count] + '</p>';
                        }
                        html += '</div>';
                    }
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success +
                            '</div>';
                        $('#formUser')[0].reset();
                        $('#tableUser').DataTable().ajax.reload();
                        // setTimeout(function {
                        $('#formInputUpdate').modal('hide');
                        // },1000);
                    }
                    $('#form_result').html(html);
                },
                error: function(data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
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
