<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();

        // Get logged-in teacher's ID from session
        $user = $request->session()->get("nomor_induk");
        $checkUser = DB::table('users')
            ->where("nomor_induk", "=", $user)
            ->value("id"); // Use `value` if only a single ID is expected


        // Retrieve today's schedule for the teacher
        $checkjadwal = DB::table("jadwals")
            ->join("kelas", "jadwals.kelas_id", "=", "kelas.id")
            ->join("mata_pelajarans", "jadwals.mapel_id", "=", "mata_pelajarans.id")
            ->where('jadwals.user_id', "=", $checkUser)
            ->where('jadwals.hari', '=', $dayName)
            ->select('jadwals.*', 'kelas.kelas as kelas_name', 'kelas.jenis_kelas as kelas_jenis', 'mata_pelajarans.nama_mapel as mapel_name')
            ->get();
        $checkjadwaluser = DB::table("jadwals")
            ->join("kelas", "jadwals.kelas_id", "=", "kelas.id")
            ->join("user_kelas", 'kelas.id', '=', 'user_kelas.kelas_id')
            ->join("mata_pelajarans", "jadwals.mapel_id", "=", "mata_pelajarans.id")
            ->where('user_kelas.user_id', "=", $checkUser)
            ->where('jadwals.hari', '=', $dayName)
            ->select('jadwals.*', 'kelas.kelas as kelas_name', 'kelas.jenis_kelas as kelas_jenis', 'mata_pelajarans.nama_mapel as mapel_name')
            ->get();
        // If the request is AJAX, return presensi data for DataTables
        // dd($checkjadwaluser);
        if ($request->ajax()) {
            $data = DB::table('presensis')
                ->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
                ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('detail_presensis', 'presensis.id', '=', 'detail_presensis.presensi_id')
                ->where('jadwals.user_id', '=', $checkUser)
                ->select(
                    'presensis.id',
                    'presensis.tanggal',
                    'jadwals.hari',
                    'mata_pelajarans.kode_mapel',
                    'kelas.jenis_kelas',
                    DB::raw('SUM(CASE WHEN detail_presensis.status = "A" THEN 1 ELSE 0 END) as alpha'),
                    DB::raw('SUM(CASE WHEN detail_presensis.status = "H" THEN 1 ELSE 0 END) as hadir'),
                    DB::raw('SUM(CASE WHEN detail_presensis.status = "S" THEN 1 ELSE 0 END) as sakit'),
                    DB::raw('SUM(CASE WHEN detail_presensis.status = "I" THEN 1 ELSE 0 END) as ijin'),
                    DB::raw('CONCAT(kelas.kelas, " ", kelas.jenis_kelas) AS kelas_jenis'),
                    DB::raw('CASE 
                WHEN jadwals.jam_mulai <= "10:00:00" AND jadwals.jam_selesai >= "10:15:00" THEN TIMESTAMPDIFF(MINUTE, jadwals.jam_mulai, jadwals.jam_selesai) - 15
                WHEN jadwals.jam_mulai <= "11:45:00" AND jadwals.jam_selesai >= "12:15:00" THEN TIMESTAMPDIFF(MINUTE, jadwals.jam_mulai, jadwals.jam_selesai) - 30
                WHEN jadwals.hari = "Friday" AND jadwals.jam_mulai <= "09:15:00" AND jadwals.jam_selesai >= "09:30:00" THEN TIMESTAMPDIFF(MINUTE, jadwals.jam_mulai, jadwals.jam_selesai) - 15
                ELSE TIMESTAMPDIFF(MINUTE, jadwals.jam_mulai, jadwals.jam_selesai)
            END AS total_menit')
                )
                ->groupBy(
                    'presensis.id',
                    'presensis.tanggal',
                    'jadwals.hari',
                    'mata_pelajarans.kode_mapel',
                    'kelas.kelas',
                    'kelas.jenis_kelas',
                    'jadwals.jam_mulai',
                    'jadwals.jam_selesai'
                )
                ->get()
                ->map(function ($item) {
                    $item->total_jam = round($item->total_menit / 45, 2); // convert minutes to hours
                    return $item;
                });

            return DataTables::of($data)
                ->addColumn('aksi', function ($data) {
                    return '<a href="' . route('user.presensi.edit', ['presensi' => $data->id]) . '" class="btn btn-primary mb-2"><i class="fas fa-pen"></i> Edit</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        // Render the dashboard view with necessary data
        return view('dashboard', compact('checkjadwal', 'checkjadwaluser', 'currentDate', 'dayName', 'currentTime'));
    }
    public function loadChartData(Request $request)
    {
        // $semesterData = DB::table('presensis')
        //     ->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
        //     ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
        //     ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
        //     ->join('detail_presensis', 'presensis.id', '=', 'detail_presensis.presensi_id')
        //     ->select(
        //         DB::raw('CONCAT(YEAR(presensis.tanggal), "-", CEIL(MONTH(presensis.tanggal) / 6)) AS semester'), // Group by 6-month periods
        //         DB::raw('SUM(CASE WHEN detail_presensis.status = "A" THEN 1 ELSE 0 END) AS alpha'),
        //         DB::raw('SUM(CASE WHEN detail_presensis.status = "H" THEN 1 ELSE 0 END) AS hadir'),
        //         DB::raw('SUM(CASE WHEN detail_presensis.status = "S" THEN 1 ELSE 0 END) AS sakit'),
        //         DB::raw('SUM(CASE WHEN detail_presensis.status = "I" THEN 1 ELSE 0 END) AS ijin')
        //     )
        //     ->groupBy('semester')
        //     ->get();

        $kelas10 = DB::table('presensis')
            ->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('detail_presensis', 'presensis.id', '=', 'detail_presensis.presensi_id')
            ->select(
                DB::raw('CONCAT(YEAR(presensis.tanggal), "-", CEIL(MONTH(presensis.tanggal) / 6)) AS semester'), // Group by 6-month periods
                DB::raw('SUM(CASE WHEN detail_presensis.status = "A" THEN 1 ELSE 0 END) AS alpha'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "H" THEN 1 ELSE 0 END) AS hadir'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "S" THEN 1 ELSE 0 END) AS sakit'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "I" THEN 1 ELSE 0 END) AS ijin')
            )
            ->where('kelas', '=', '10')
            ->groupBy('semester')
            ->get();
        $kelas11 = DB::table('presensis')->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('detail_presensis', 'presensis.id', '=', 'detail_presensis.presensi_id')
            ->select(
                DB::raw('CONCAT(YEAR(presensis.tanggal), "-", CEIL(MONTH(presensis.tanggal) / 6)) AS semester'), // Group by 6-month periods
                DB::raw('SUM(CASE WHEN detail_presensis.status = "A" THEN 1 ELSE 0 END) AS alpha'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "H" THEN 1 ELSE 0 END) AS hadir'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "S" THEN 1 ELSE 0 END) AS sakit'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "I" THEN 1 ELSE 0 END) AS ijin')
            )
            ->where('kelas', '=', '11')
            ->groupBy('semester')
            ->get();
        $kelas12 = DB::table('presensis')
            ->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('detail_presensis', 'presensis.id', '=', 'detail_presensis.presensi_id')
            ->select(
                DB::raw('CONCAT(YEAR(presensis.tanggal), "-", CEIL(MONTH(presensis.tanggal) / 6)) AS semester'), // Group by 6-month periods
                DB::raw('SUM(CASE WHEN detail_presensis.status = "A" THEN 1 ELSE 0 END) AS alpha'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "H" THEN 1 ELSE 0 END) AS hadir'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "S" THEN 1 ELSE 0 END) AS sakit'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "I" THEN 1 ELSE 0 END) AS ijin')
            )
            ->where('kelas', '=', '12')
            ->groupBy('semester')
            ->get();
        return response()->json(['kelas10' => $kelas10, 'kelas11' => $kelas11, 'kelas12' => $kelas12]);
    }
};
