@extends('layout.main', ['title' => 'Presensi'])

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('lte/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Presensi</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content col-12">
            <div class="row">

                <div class="card camera-card col-md-6">
                    <div class="card-body display-cover">
                        <video autoplay></video>
                        <canvas class="d-none"></canvas>

                        <div class="video-options">
                            <select class="custom-select">
                                <option value="">Select camera</option>
                            </select>
                        </div>

                        <img class="screenshot-image d-none" id="taken_pict" alt="">

                        <div class="controls">
                            <button class="btn btn-success" title="Play">
                                Aktifkan kamera
                            </button>
                            <button class="btn btn-outline-success screenshot d-none" title="ScreenShot">
                                Scan Wajah
                            </button>

                            <form action="{{ route('user.presensis') }}" id="image_form" method="post">
                                @csrf
                                <input type="hidden" id="image_take" name="image">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card card-primary col-md-6">
                    <div class="card-header">
                        {{ $jdwlsaatini->kelas . ' ' . $jdwlsaatini->jenis_kelas . ' / ' . $jdwlsaatini->jam_mulai . ' - ' . $jdwlsaatini->jam_selesai . ' / ' . $jdwlsaatini->nama_mapel }}
                    </div>
                    <h5 class="card-title">
                        <form action="{{ route('user.presensi.validasi') }}" method="POST" id="presensiForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="nomor_induk" value="{{ Session::get('nomor_induk') }}">
                            <input type="hidden" name="detail_presensi_id"
                                value="{{ Session::get('detail_presensi_id') }}">
                            <input type="hidden" name="presensis_id" value="{{ Session::get('presensis_id') }}">
                            <input type="hidden" name="detail_presensis_status" value="H">
                            <button type="submit" style="display: none;"></button>
                        </form>
                    </h5>
                    <div class="card-body">
                        <table id="tableSiswa" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="{{ asset('script.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('lte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            loadData();
            loadSelect();

            @if (Session::has('label') && Session::get('label') == Session::get('nomor_induk'))
                document.getElementById('presensiForm').submit();
            @endif
        });

        function loadSelect() {
            navigator.mediaDevices.enumerateDevices()
                .then(devices => {
                    const videoSelect = document.querySelector('.video-options select');
                    devices.forEach(device => {
                        if (device.kind === 'videoinput') {
                            const option = document.createElement('option');
                            option.value = device.deviceId;
                            option.text = device.label || `Camera ${videoSelect.length + 1}`;
                            videoSelect.appendChild(option);
                        }
                    });
                });
        }

        function loadData() {
            var table = $('#tableSiswa').DataTable({
                searchDelay: 350,
                processing: true,
                paging: false,
                autoWidth: false,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                destroy: true,
                ajax: {
                    url: "{{ route('user.presensi.siswa') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ],
                deferRender: true
            });
        }
    </script>
    @if ($message = Session::get('failed'))
        <script>
            Swal.fire('{{ $message }}');
        </script>
    @endif

    @if ($message = Session::get('message'))
        <script>
            Swal.fire('{{ $message }}');
        </script>
    @endif
@endsection
