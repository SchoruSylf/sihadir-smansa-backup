@extends('layout.main', ['title' => 'Data Kelas'])
@section('css')
    <link rel="stylesheet" href="https:/cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
@endsection
@section('content-wrapper')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Data Kelas</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="card card-primary">
                        <div class="table-responsive p-2">
                            <table id="tableKelas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kelas</th>
                                        <th>Jenis Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data as $item)
                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="modal-update-kelas{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-updateLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data Kelas</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- form Update -->
                                                        <form
                                                            action="{{ route('user.kelas.update', ['id_kelas' => $item->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label>Kelas</label>
                                                                    <select name="kelas" class="form-control"
                                                                        id="exampleInputEmail1">
                                                                        <option value="{{ $item->kelas }}">
                                                                            {{ $item->kelas }}</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </div>
                                                                @error('kelas')
                                                                    <small style="color: red">{{ $message }}</small>
                                                                @enderror
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Jenis Kelas</label>
                                                                    <input type="text" inputmode="numeric"
                                                                        name="jenis_kelas" value="{{ $item->jenis_kelas }}"
                                                                        id="exampleInputEmail1" class="form-control"
                                                                        placeholder="A / B / Informatika / Musik"
                                                                        pattern="[a-zA-Z]{1,20}">
                                                                </div>
                                                                @error('jenis_kelas')
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
                                        <div class="modal fade" id="modal-delete-kelas{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modal-deleteLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Konfirmasi Hapus Kelas</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah anda yakin ingin menghapus data Kelas
                                                            <b>{{ $item->kelas }} {{ $item->jenis_kelas }}</b>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content">
                                                        <form
                                                            action="{{ route('user.kelas.delete', ['id_kelas' => $item->id]) }}"
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
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Tambah Kelas</div>
                        </div>
                        <form action="{{ route('user.kelas.input') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="kelas" class="form-control">
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                @error('kelas')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                                <div class="form-group">
                                    <label for="jenis_kelas">Jenis Kelas</label>
                                    <input type="text" name="jenis_kelas" class="form-control"
                                        placeholder="A / B / Informatika / Musik" pattern="[a-zA-Z]{1,30}">
                                </div>
                                @error('jenis_kelas')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            loadData();
        });

        function loadData() {
            $('#tableKelas').DataTable({
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
                    url: "{{ route('user.kelas.read') }}",
                },
                columns: [{
                        data: 'kelas',
                        name: 'kelas',
                    },
                    {
                        data: 'jenis_kelas',
                        name: 'jenis_kelas',
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
