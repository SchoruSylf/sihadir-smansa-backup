<?php

namespace App\Http\Controllers;

use App\Exports\ExportPresensi;
use App\Exports\ExportUser;
use App\Exports\ExportUserDummy;
use App\Exports\ExportUserKelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function user_export(Request $request)
    {
        $currentYear = date('Y');
        return Excel::download(new ExportUser, "Semua Pengguna SIHADIR SMANSA $currentYear .xlsx");
    }
    public function user_export_dummy(Request $request)
    {
        $currentYear = date('Y');
        return Excel::download(new ExportUserDummy, "Contoh Semua Pengguna SIHADIR SMANSA $currentYear .xlsx");
    }

    public function user_kelas_export_dummy(Request $request)
    {
        $currentYear = date('Y');
        return Excel::download(new ExportUserKelas, "Contoh Data Siswa Kelas SIHADIR SMANSA $currentYear .xlsx");
    }

    public function detail_presensis(Request $request)
    {
        $currentYear = date('Y');
        return Excel::download(new ExportPresensi, "Laporan Presensi Siswa $currentYear .xlsx");
    }
}
