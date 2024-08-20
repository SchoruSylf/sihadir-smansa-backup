<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('presensis')
                ->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
                ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
                ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
                ->join('detail_presensis', 'presensis.id', '=', 'detail_presensis.presensi_id')
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
        return view('guru.riwayat_presensi');
    }

    public function loadChartData(Request $request)
    {    // Define the start and end months for each semester
        $semesterData = DB::table('presensis')
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
            ->groupBy('semester')
            ->get();

        $monthData = DB::table('presensis')
            ->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('detail_presensis', 'presensis.id', '=', 'detail_presensis.presensi_id')
            ->select(
                DB::raw('DATE_FORMAT(presensis.tanggal, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "A" THEN 1 ELSE 0 END) AS alpha'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "H" THEN 1 ELSE 0 END) AS hadir'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "S" THEN 1 ELSE 0 END) AS sakit'),
                DB::raw('SUM(CASE WHEN detail_presensis.status = "I" THEN 1 ELSE 0 END) AS ijin')
            )
            ->groupBy(DB::raw('DATE_FORMAT(presensis.tanggal, "%Y-%m")'))
            ->get();

        return response()->json(['semester' => $semesterData, 'month' => $monthData]);
    }
}
