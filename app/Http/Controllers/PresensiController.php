<?php

namespace App\Http\Controllers;

use App\Models\Detail_presensi;
use App\Models\Jadwal;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\select;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();

        // Get the current schedule for the logged-in teacher
        $jdwlsaatini = DB::table('jadwals')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('user_kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            // ->where('jadwals.user_id', '=', auth()->id())
            ->where('hari', '=', $dayName)
            // ->where('jadwals.jam_mulai', '<=', $currentTime)
            // ->where('jadwals.jam_selesai', '>=', $currentTime)
            ->first();

        if ($jdwlsaatini !== null) {
            // Check if there is already a presence record for today
            $checkpresensi = DB::table('presensis')
                ->where('jadwal_id', '=', $jdwlsaatini->id)
                ->where('tanggal', '=', $currentDate)
                ->first();

            // Get the students for the current class
            $siswas = DB::table('users')
                ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
                ->where('user_kelas.kelas_id', '=', $jdwlsaatini->kelas_id)
                ->get();

            $siswa = DB::table('detail_presensis')
                ->join('presensis', 'detail_presensis.presensi_id', '=', 'presensis.id')
                ->join('users', 'detail_presensis.user_id', '=', 'users.id')
                ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
                ->join('kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
                ->where('kelas.id', '=', $jdwlsaatini->kelas_id)
                ->where('presensis.tanggal', '=', $currentDate)
                ->where('presensis.jadwal_id', '=', $jdwlsaatini->id)
                ->get(['detail_presensis.id', 'users.nomor_induk', 'user_kelas.user_id', 'users.name', 'detail_presensis.status']);

            if ($request->ajax()) {
                return DataTables::of($siswa)
                    ->addColumn('name', function ($siswa) {
                        return $siswa->nomor_induk . ' - ' . $siswa->name;
                    })
                    ->addColumn('status', function ($siswa) {
                        return $siswa->status;
                    })
                    ->make(true);
            }

            return view('siswa.presensi');
        } else {
            return redirect()->route('user.dashboard')->with('failed', 'Mata Pelajaran pada jam ini belum ada');
        }
    }
    public function guru(Request $request)
    {
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();

        // Get the current schedule for the logged-in teacher
        $jdwlsaatini = DB::table('jadwals')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('user_kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            ->where('jadwals.user_id', '=', auth()->id())
            ->where('hari', '=', $dayName)
            // ->where('jadwals.jam_mulai', '<=', $currentTime)
            // ->where('jadwals.jam_selesai', '>=', $currentTime)
            ->first();

        if ($jdwlsaatini !== null) {
            // Check if there is already a presence record for today
            $checkpresensi = DB::table('presensis')
                ->where('jadwal_id', '=', $jdwlsaatini->id)
                ->where('tanggal', '=', $currentDate)
                ->first();

            // Get the students for the current class
            $siswas = DB::table('users')
                ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
                ->where('user_kelas.kelas_id', '=', $jdwlsaatini->kelas_id)
                ->get();

            // If no presence record exists, create one
            if ($checkpresensi === null) {
                $data = [
                    'jadwal_id' => $jdwlsaatini->id,
                    'user_id'   => $jdwlsaatini->user_id,
                    'tanggal'   => $currentDate,
                ];

                // Insert new presence record
                $presensi_id = DB::table('presensis')->insertGetId($data);

                // Insert presence details for each student
                foreach ($siswas as $siswa) {
                    $detailPresensi = [
                        'presensi_id' => $presensi_id,
                        'user_id'     => $siswa->user_id,
                        'jam_masuk'   => $currentTime,
                        'jam_keluar'  => null,
                        'status'      => 'A',
                    ];

                    // Insert detail presence
                    Detail_presensi::create($detailPresensi);
                }
            }

            // Get the presence details for the current date and class
            $siswa = DB::table('detail_presensis')
                ->join('presensis', 'detail_presensis.presensi_id', '=', 'presensis.id')
                ->join('users', 'detail_presensis.user_id', '=', 'users.id')
                ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
                ->join('kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
                ->where('kelas.id', '=', $jdwlsaatini->kelas_id)
                ->where('presensis.tanggal', '=', $currentDate)
                ->where('presensis.jadwal_id', '=', $jdwlsaatini->id)
                ->get(['detail_presensis.id', 'users.nomor_induk', 'user_kelas.user_id', 'users.name', 'detail_presensis.status']);

            if ($request->ajax()) {
                return DataTables::of($siswa)
                    ->addColumn('name', function ($siswa) {
                        return $siswa->nomor_induk . ' - ' . $siswa->name;
                    })
                    ->addColumn('status', function ($siswa) {
                        return $siswa->status;
                    })
                    ->addColumn('aksi', function ($siswa) {
                        return '<a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-presensi-edit' . $siswa->id . '"><i class="fas fa-pen"></i> Edit</a>
                        ';
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            return view('guru.presensi', compact('jdwlsaatini', 'siswa'));
        } else {
            if ($currentTime > '15:15:00') {
                return redirect()->route('user.dashboard')->with('failed', 'Mata Pelajaran pada hari ini sudah selesai');
            }
            return redirect()->route('user.dashboard')->with('failed', 'Mata Pelajaran pada jam ini belum ada');
        }
    }
    public function update_presensi(Request $request, $detail_presensi)
    {
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();

        // Get the current schedule for the logged-in teacher
        $jdwlsaatini = DB::table('jadwals')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('user_kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            ->where('jadwals.user_id', '=', auth()->id())
            ->where('hari', '=', $dayName)
            ->where('jadwals.jam_mulai', '<=', $currentTime)
            ->where('jadwals.jam_selesai', '>=', $currentTime)
            ->first();

        // Get the specific detail_presensi record for the student
        $detailPresensi = DB::table('detail_presensis')
            ->join('presensis', 'detail_presensis.presensi_id', '=', 'presensis.id')
            ->join('users', 'detail_presensis.user_id', '=', 'users.id')
            ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
            ->join('kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
            ->where('kelas.id', '=', $jdwlsaatini->kelas_id)
            ->where('presensis.tanggal', '=', $currentDate)
            ->where('presensis.jadwal_id', '=', $jdwlsaatini->id)
            ->where('detail_presensis.id', '=', $detail_presensi)
            ->first();

        // Check if the detail_presensi record exists
        if ($detailPresensi) {
            // Update the status
            DB::table('detail_presensis')
                ->where('id', $detail_presensi)
                ->update(['status' => $request->input('status')]);

            return redirect()->route('user.presensi.guru')->with('success', 'Status siswa telah diperbaharui');
        } else {
            return redirect()->route('user.presensi.guru')->with('error', 'Record not found or invalid!');
        }
    }
    public function check_face(Request $request)
    {
        // $response =  Http::post('http://127.0.0.1:5000/', $request->only('image'));
        // return $response;
        $response = Http::post('http://127.0.0.1:5000/', $request->only('image'));
        // Check if the request was successful
        if ($response->successful()) {
            // Assuming the response is in JSON format
            $responseData = $response->json();

            // Extract the label from the response data
            $label = $responseData[0]["label"]; // Assuming $responseData is an array of objects
            // Now you can use $label as needed
            // For example, you can return it in a redirect
            return redirect()->route('user.presensi.siswa')->with('label', $label);
        } else {
            // Handle the case where the request was not successful
            // For example, return an error message
            return back()->withErrors('Failed to retrieve label.');
        }
    }
}
