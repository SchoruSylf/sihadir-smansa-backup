@extends('layout.main', ['title' => 'Data Jadwal'])
@section('css')
    <link rel="stylesheet" href="https:/cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
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
                        <h1>Data Jadwal</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Tambah Jadwal  -->
                <div class="col-12">
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-input">
                        <i class="fas fa-user-plus"></i> Tambah Jadwal</a>
                    <div class="modal fade" id="modal-input">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Input Data Jadwal</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form Input -->
                                    <form action="{{ route('user.jadwal.input') }}" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="hari">Hari</label>
                                                <select name="hari" id="hari" class="form-control select2"
                                                    style="width: 100%;">
                                                    <option value=""></option>
                                                    <option value="Senin">Senin</option>
                                                    <option value="Selasa">Selasa</option>
                                                    <option value="Rabu">Rabu</option>
                                                    <option value="Kamis">Kamis</option>
                                                    <option value="Jumat">Jumat</option>
                                                    <!-- Add more days if necessary -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Kelas</label>
                                                <select class="select2" id="kelas" style="width: 100%;">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Mata Pelajaran</label>
                                                <select class="select2" id="mapel" style="width: 100%;">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Guru</label>
                                                <select class="select2" id="guru" style="width: 100%;">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Jam Mulai</label>
                                                <select name="jam_mulai" id="jam_mulai" class="form-control">
                                                    <option value=""></option>
                                                    <option value="06:45">06:45</option>
                                                    <option value="07:00">07:00</option>
                                                    <option value="07:45">07:45</option>
                                                    <option value="08:30">08:30</option>
                                                    <option value="09:15">09:15</option>
                                                    <option value="09:30">09:30</option>
                                                    <option value="10:15">10:15</option>
                                                    <option value="11:00">11:00</option>
                                                    <option value="12:15">12:15</option>
                                                    <option value="13:00">13:00</option>
                                                    <option value="13:45">13:45</option>
                                                    <option value="14:30">14:30</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Jam Selesai</label>
                                                <select name="jam_selesai" id="jam_selesai" class="form-control">
                                                    <option value=""></option>
                                                    <option value="07:00">07:00</option>
                                                    <option value="07:45">07:45</option>
                                                    <option value="08:30">08:30</option>
                                                    <option value="09:15">09:15</option>
                                                    <option value="10:00">10:00</option>
                                                    <option value="10:15">10:15</option>
                                                    <option value="11:00">11:00</option>
                                                    <option value="11:45">11:45</option>
                                                    <option value="13:00">13:00</option>
                                                    <option value="13:45">13:45</option>
                                                    <option value="14:30">14:30</option>
                                                    <option value="15:15">15:15</option>
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
                    <!-- /.modal -->
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-input-mass">
                        <i class="fas fa-users"></i> Tambah Jadwal file XLSX</a>
                    <div class="modal fade" id="modal-input-mass">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Input Data Jadwal</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- form Input -->
                                    <a class="btn btn-warning ml-3" href="{{ route('user.jadwal.exports') }}">
                                        Contoh Format file .xlsx
                                    </a>
                                    <form action="{{ route('user.jadwal.input.mass') }}" method="POST"
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
                                                            jadwal </label>
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
                        Export Jadwal
                    </a>
                </div>
                <!-- Display Data -->
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-body">
                            <!--Semua -->
                            <div class="table-responsive p-2">
                                <table id="tableJadwal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Hari</th>
                                            <th>Waktu Pelajaran</th>
                                            <th>Kelas</th>
                                            <th>Kode Mapel</th>
                                            <th>Nama Mapel</th>
                                            <th>Guru</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jadwal as $jadwals)
                                            <div class="modal fade" id="modal-update-jadwal{{ $jadwals->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="modal-update-userLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Data Jadwal</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- form Update -->
                                                            <form
                                                                action="{{ route('user.jadwal.update', ['id_jadwal' => $jadwals->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label>Hari</label>
                                                                        <select name="hari" id=""
                                                                            class="form-control">
                                                                            <option value={{ $jadwals->hari }}>
                                                                                {{ $jadwals->hari }}</option>
                                                                            <option value="Senin">Senin</option>
                                                                            <option value="Selasa">Selasa</option>
                                                                            <option value="Rabu">Rabu</option>
                                                                            <option value="Kamis">Kamis</option>
                                                                            <option value="Jum'at">Jum'at</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Jam Mulai</label>
                                                                        <select name="jam_mulai" id="jam_mulai"
                                                                            class="form-control">
                                                                            <option value={{ $jadwals->jam_mulai }}>
                                                                                {{ $jadwals->jam_mulai }}</option>
                                                                            <option value="06:45">06:45</option>
                                                                            <option value="07:00">07:00</option>
                                                                            <option value="07:45">07:45</option>
                                                                            <option value="08:30">08:30</option>
                                                                            <option value="09:15">09:15</option>
                                                                            <option value="09:30">09:30</option>
                                                                            <option value="10:15">10:15</option>
                                                                            <option value="11:00">11:00</option>
                                                                            <option value="12:15">12:15</option>
                                                                            <option value="13:00">13:00</option>
                                                                            <option value="13:45">13:45</option>
                                                                            <option value="14:30">14:30</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Jam Selesai</label>
                                                                        <select name="jam_selesai" id="jam_selesai"
                                                                            class="form-control">
                                                                            <option value={{ $jadwals->jam_selesai }}>
                                                                                {{ $jadwals->jam_selesai }}</option>
                                                                            <option value="07:00">07:00</option>
                                                                            <option value="07:45">07:45</option>
                                                                            <option value="08:30">08:30</option>
                                                                            <option value="09:15">09:15</option>
                                                                            <option value="10:00">10:00</option>
                                                                            <option value="10:15">10:15</option>
                                                                            <option value="11:00">11:00</option>
                                                                            <option value="11:45">11:45</option>
                                                                            <option value="13:00">13:00</option>
                                                                            <option value="13:45">13:45</option>
                                                                            <option value="14:30">14:30</option>
                                                                            <option value="15:15">15:15</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Kelas</label>
                                                                        <select class="select2"
                                                                            id="kelas-update-{{ $jadwals->id }}"
                                                                            style="width: 100%;"></select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Mata Pelajaran</label>
                                                                        <select class="select2"
                                                                            id="mapel-update-{{ $jadwals->id }}"
                                                                            style="width: 100%;"></select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Guru</label>
                                                                        <select class="select2"
                                                                            id="guru-update-{{ $jadwals->id }}"
                                                                            style="width: 100%;"></select>
                                                                    </div>
                                                                </div>
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
                                            <div class="modal fade" id="modal-delete-jadwal{{ $jadwals->id }}"
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
                                                            <p>Apakah anda yakin ingin menghapus jadwal
                                                                <b>{{ $jadwals->kode_mapel }}</b>
                                                                <b>{{ $jadwals->hari }}</b> di
                                                                <b>{{ $jadwals->kelas . ' ' . $jadwals->jenis_kelas }}
                                                                    {{-- @dd($jadwals) --}}
                                                                </b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content">
                                                            <form
                                                                action="{{ route('user.jadwal.delete', ['id_jadwal' => $jadwals->id]) }}"
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('lte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('#modal-input').on('shown.bs.modal', function() {
            loadSelectGuru('guru');
            loadSelectKelas('kelas');
            loadSelectMapel('mapel');
        });

        function loadData() {
            $('#tableJadwal').DataTable({
                searchDelay: 400,
                processing: true,
                paging: true,
                autoWidth: false,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                destroy: true,
                ajax: {
                    url: "{{ route('user.jadwal.read') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'hari',
                        name: 'hari'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'kode_mapel',
                        name: 'kode_mapel'
                    },
                    {
                        data: 'nama_mapel',
                        name: 'nama_mapel'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function(settings) { //Error can't search
                    // Reinitialize Select2 on each row
                    $('.select2').select2({
                        placeholder: 'Pilih hari jadwal',
                        allowClear: true
                    });

                    // Loop through each jadwal to apply Select2 for update forms
                    @foreach ($jadwal as $jadwals)
                        loadSelectGuru('guru-update-{{ $jadwals->id }}');
                        loadSelectKelas('kelas-update-{{ $jadwals->id }}');
                        loadSelectMapel('mapel-update-{{ $jadwals->id }}');
                    @endforeach
                },
                deferRender: true,
            });
        }

        function loadSelectGuru(elementId) {
            $('#' + elementId).select2({
                placeholder: 'Cari Berdasarkan NIP atau Nama Guru',
                ajax: {
                    url: "{{ route('user.jadwal.read_selector_user') }}",
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
            }).attr('name', 'guru');
        }

        function loadSelectKelas(elementId) {
            $('#' + elementId).select2({
                placeholder: 'Cari Berdasarkan Kelas atau Jenis Kelas',
                ajax: {
                    url: "{{ route('user.jadwal.read_selector_kelas') }}",
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
                                    text: item.kelas + ' ' + item.jenis_kelas
                                };
                            })
                        };
                    },
                    cache: true
                }
            }).attr('name', 'kelas');
        }

        function loadSelectMapel(elementId) {
            $('#' + elementId).select2({
                placeholder: 'Cari Berdasarkan Kode Mapel atau Nama Mapel',
                ajax: {
                    url: "{{ route('user.jadwal.read_selector_mapel') }}",
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
                                    text: '( ' + item.kode_mapel + ' ) ' + item.nama_mapel
                                };
                            })
                        };
                    },
                    cache: true
                }
            }).attr('name', 'mapel');
        }
        $(document).ready(function() {
            loadData();
            $('.select2').select2();

            const availableTimes = [
                "06:45", "07:00", "07:45", "08:30", "09:15",
                "10:00", "10:15", "11:00", "11:45", "13:00",
                "13:45", "14:30", "15:15"
            ];

            $('#kelas, #hari').on('change', function() {
                var kelas = $('#kelas').val();
                var hari = $('#hari').val();

                if (kelas && hari) {
                    $.ajax({
                        url: '{{ route('user.user.jadwal.unavailable_times') }}',
                        type: 'GET',
                        data: {
                            kelas: kelas,
                            hari: hari
                        },
                        success: function(data) {
                            $('#jam_mulai').empty();
                            $('#jam_selesai').empty();

                            const unavailableTimes = data.map(schedule => schedule.jam_mulai);

                            const filteredTimes = availableTimes.filter(time => !
                                unavailableTimes.includes(time));

                            filteredTimes.forEach(function(time) {
                                $('#jam_mulai').append('<option value="' + time + '">' +
                                    time + '</option>');
                            });

                            $('#jam_mulai').select2();
                            $('#jam_selesai').select2();
                        }
                    });
                }
            });

            $('#jam_mulai').on('change', function() {
                var kelas = $('#kelas').val();
                var hari = $('#hari').val();
                var jamMulai = $(this).val();

                if (kelas && hari && jamMulai) {
                    $('#jam_selesai').empty();

                    const filteredEndTimes = availableTimes.filter(function(time) {
                        return time > jamMulai;
                    });

                    $.ajax({
                        url: '{{ route('user.jadwal.check_selesai') }}',
                        type: 'GET',
                        data: {
                            kelas: kelas,
                            hari: hari,
                            jam_mulai: jamMulai
                        },
                        success: function(data) {
                            const unavailableEndTimes = data.map(schedule => schedule
                                .jam_selesai);

                            const validEndTimes = filteredEndTimes.filter(time => !
                                unavailableEndTimes.includes(time));

                            validEndTimes.forEach(function(time) {
                                $('#jam_selesai').append('<option value="' + time +
                                    '">' + time + '</option>');
                            });

                            $('#jam_selesai').select2();
                        }
                    });
                }
            });
        });
    </script>
@endsection
