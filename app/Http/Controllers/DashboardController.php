<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data_pengguna = "asd";
        // $value = Session::get('label');
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();
        $guru = $request->session()->get("nomor_induk");
        $checkguru = DB::table('users')
            ->where("nomor_induk", "=", $guru)
            ->pluck("id");
            $checkjadwal = DB::table("jadwals")
            ->join("kelas", "jadwals.kelas_id", "=", "kelas.id") // Specify table for kelas_id
            ->join("mata_pelajarans", "jadwals.mapel_id", "=", "mata_pelajarans.id") // Specify table for mapel_id
            ->where('jadwals.user_id', "=", $checkguru) // Specify table for user_id
            ->where('jadwals.hari', '=', $dayName) // Specify table for hari
            ->where('jam_selesai','>',$currentTime)
            ->select('jadwals.*', 'kelas.kelas as kelas_name', 'kelas.jenis_kelas as kelas_jenis', 'mata_pelajarans.nama_mapel as mapel_name') // Select specific fields
            ->get();        
        return view('dashboard', compact('checkjadwal', 'currentDate', 'dayName'));
    }
}
