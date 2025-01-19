@extends('layout.main', ['title' => 'Profile'])
@section('content-wrapper')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Nama : {{ Session::get('name') }}</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <div class="card-body">
                                Nomor Induk : {{ Session::get('nomor_induk') }}
                                <br>
                                Role :
                                @php
                                    $role = Session::get('role');
                                @endphp
                                @if ($role == 1)
                                    Admin
                                @elseif ($role == 2)
                                    Guru
                                @elseif ($role == 3)
                                    Siswa
                                @else
                                    Unknown Role
                                @endif
                                <br>
                                @if ($role == 2)
                                    Wali Kelas : -
                                @elseif ($role == 3)
                                    Kelas :
                                    @foreach ($kelas as $item)
                                        {{ $item->kelas }}, <!-- Or any other field you want to display -->
                                    @endforeach
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a name="" id="" class="btn btn-danger" href="{{ route('keluar') }}"
                                    role="button">Log out</a>
                            </div>
                            <!-- /.card-footer-->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
