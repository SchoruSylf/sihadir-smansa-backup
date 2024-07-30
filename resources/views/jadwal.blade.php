@extends('layout.main', ['title' => 'Jadwal'])

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
@endsection

@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Jadwal</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered custom-table">
                            <thead>
                                <tr class="header-row">
                                    <th rowspan="2" class="hari-column">HARI</th>
                                    <th rowspan="2" class="waktu-column">WAKTU</th>
                                    <th colspan="12">KELAS X</th>
                                    <th colspan="12">KELAS XI</th>
                                    <th colspan="12">KELAS XII</th>
                                </tr>
                                <tr class="header-row">
                                    @for ($i = 0; $i < 3; $i++)
                                        @foreach (range('A', 'L') as $column)
                                            <th>{{ $column }}</th>
                                        @endforeach
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedSchedules as $day => $timeRanges)
                                    @foreach ($timeRanges as $timeRangeData)
                                        @if ($timeRangeData['is_break'])
                                            <tr class="istirahat-cell">
                                                @if ($loop->first)
                                                    <td rowspan="{{ $timeRanges->count() }}" class="hari-column">
                                                        {{ $day }}</td>
                                                @endif
                                                <td>{{ $timeRangeData['time_range'] }}</td>
                                                <td colspan="36">ISTIRAHAT</td>
                                            </tr>
                                        @else
                                            <tr
                                                class="{{ $loop->parent->last && $day === 'Jumat' ? 'bottom-border-bold' : '' }}">
                                                @if ($loop->first)
                                                    <td rowspan="{{ $timeRanges->count() }}" class="hari-column">
                                                        {{ $day }}</td>
                                                @endif
                                                <td>{{ $timeRangeData['time_range'] }}</td>
                                                @foreach (range(10, 12) as $kelas)
                                                    @foreach (range('A', 'L') as $column)
                                                        <td>{{ $timeRangeData['slots'][$kelas][$column] }}</td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
