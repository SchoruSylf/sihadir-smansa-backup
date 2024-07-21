<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use App\Exports\ExportUserDummy;
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
}
