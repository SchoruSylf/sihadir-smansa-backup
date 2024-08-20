@extends('layout.main', ['title' => 'Edit Presensi'])

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Presensi</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-tabs">
                        <div class="card-header">
                            {{ $jdwl->kelas . ' ' . $jdwl->jenis_kelas . ' / ' . $jdwl->jam_mulai . ' - ' . $jdwl->jam_selesai . ' / ' . $jdwl->nama_mapel }}
                        </div>
                        <div class="card-body">
                            <table id="tableEditPresensi" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $edit_siswa)
                                        <div class="modal fade" id="modal-presensi-edit-history{{ $edit_siswa->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="modal-update-presensiLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Status Kehadiran</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="{{ route('user.presensi.update.history', ['detail_presensi' => $edit_siswa->id, 'id' => $presensis_id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label>Nama</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $edit_siswa->name }}" disabled>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Status</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="H"
                                                                        {{ $edit_siswa->status === 'H' ? 'selected' : '' }}>
                                                                        Hadir</option>
                                                                    <option value="I"
                                                                        {{ $edit_siswa->status === 'I' ? 'selected' : '' }}>
                                                                        Izin</option>
                                                                    <option value="S"
                                                                        {{ $edit_siswa->status === 'S' ? 'selected' : '' }}>
                                                                        Sakit</option>
                                                                    <option value="A"
                                                                        {{ $edit_siswa->status === 'A' ? 'selected' : '' }}>
                                                                        Alpa</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
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
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            loadDataedit();
        });

        function loadDataedit() {
            var table = $('#tableEditPresensi').DataTable({
                searchDelay: 350,
                processing: true,
                paging: false,
                autoWidth: false,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                destroy: true,
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                    }
                ],
                deferRender: true,
            });
        }
    </script>
    @if ($message = Session::get('success'))
        <script>
            Swal.fire('{{ $message }}');
        </script>
    @endif
@endsection
