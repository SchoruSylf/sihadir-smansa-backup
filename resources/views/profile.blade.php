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
                                <h3 class="card-title">{{ Session::get('name') }}</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <div class="card-body">
                                <a name="" id="" class="btn btn-danger" href="{{ route('keluar') }}"
                                    role="button">Log out</a>
                            </div>
                            <!-- /.card-body -->
                            {{-- <div class="card-footer">
                                Footer
                            </div> --}}
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