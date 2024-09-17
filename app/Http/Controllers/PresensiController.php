<?php

namespace App\Http\Controllers;

use App\Models\Detail_presensi;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\select;

class PresensiController extends Controller
{

    public function index(Request $request)
    {
        $value = Session::get('label');
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
            ->join('user_kelas', 'jadwals.kelas_id', '=', 'user_kelas.kelas_id')
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            ->where('user_kelas.user_id', '=', auth()->id())
            ->where('hari', '=', $dayName)
            ->where('jadwals.jam_mulai', '<=', $currentTime)
            ->where('jadwals.jam_selesai', '>=', $currentTime)
            ->first();

        // Check if the class is ongoing
        if ($jdwlsaatini !== null) {
            // Check if there is already a presence record for today
            $checkpresensi = DB::table('presensis')
                ->where('jadwal_id', '=', $jdwlsaatini->id)
                ->where('tanggal', '=', $currentDate)
                ->first();

            // If presence record exists, get student attendance details
            if ($checkpresensi !== null) {
                $siswa = DB::table('detail_presensis')
                    ->join('presensis', 'detail_presensis.presensi_id', '=', 'presensis.id')
                    ->join('users', 'detail_presensis.user_id', '=', 'users.id')
                    ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
                    ->join('kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
                    ->where('kelas.id', '=', $jdwlsaatini->kelas_id)
                    ->where('presensis.tanggal', '=', $currentDate)
                    ->where('presensis.jadwal_id', '=', $jdwlsaatini->id)
                    ->get(['detail_presensis.id', 'users.nomor_induk', 'user_kelas.user_id', 'users.name', 'detail_presensis.status']);

                if ($siswa !== null) {
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

                    return view('siswa.presensi', compact('jdwlsaatini'));
                }
            } else {
                // No presence record exists, so the teacher has not started the class
                return redirect()->route('user.dashboard')->with('failed', 'Guru belum memulai kelas pada saat ini');
            }
        } else {
            if ($currentTime > '15:15:00') {
                return redirect()->route('user.dashboard')->with('failed', 'Mata Pelajaran pada hari ini sudah selesai');
            }
            return redirect()->route('user.dashboard')->with('failed', 'Guru belum memulai kelas pada saat ini');
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

        // Check for Friday condition
        if ($dayName === 'Jumat' && $currentTime > "11:00:00") {
            return redirect()->route('user.dashboard')->with('failed', 'Mata Pelajaran pada hari ini sudah selesai');
        }

        // Get the current schedule for the logged-in teacher
        $jdwlsaatini = DB::table('jadwals')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            ->where('jadwals.user_id', '=', auth()->id())
            ->where('hari', '=', $dayName)
            ->where('jadwals.jam_mulai', '<=', $currentTime)
            ->where('jadwals.jam_selesai', '>=', $currentTime)
            ->first();

        if ($jdwlsaatini !== null) {
            // Check if there is already a presence record for today
            $checkpresensi = DB::table('presensis')
                ->where('jadwal_id', '=', $jdwlsaatini->id)
                ->where('tanggal', '=', $currentDate)
                ->first();
            // dd($checkpresensi);
            // Get the students for the current class
            $siswas = DB::table('users')
                ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
                ->where('user_kelas.kelas_id', '=', $jdwlsaatini->kelas_id)
                ->get();

            if ($checkpresensi === null) {
                // No presence record exists, create one
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
            } else {
                // If presence record exists, check for new students and add their attendance record
                $existingDetails = DB::table('detail_presensis')
                    ->where('presensi_id', '=', $checkpresensi->id)
                    ->pluck('user_id')
                    ->toArray();
                // dd($existingDetails);
                foreach ($siswas as $siswa) {
                    if (!in_array($siswa->user_id, $existingDetails)) {
                        $detailPresensi = [
                            'presensi_id' => $checkpresensi->id,
                            'user_id'     => $siswa->user_id,
                            'jam_masuk'   => $currentTime,
                            'jam_keluar'  => null,
                            'status'      => 'A',
                        ];

                        // Insert detail presence for new students
                        Detail_presensi::create($detailPresensi);
                    }
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

            // dd($siswa);
            // $presensis = Db::table('presensis')
            //     ->where('presensis.jadwal_id', '=', $jdwlsaatini->id)
            //     ->select('id')
            //     ->first();
            // dd($presensis); 
            if ($request->ajax()) {
                return DataTables::of($siswa)
                    ->addColumn('name', function ($siswa) {
                        return $siswa->nomor_induk . ' - ' . $siswa->name;
                    })
                    ->addColumn('status', function ($siswa) {
                        return $siswa->status;
                    })
                    ->addColumn('aksi', function ($siswa) {
                        return '<a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-presensi-edit' . $siswa->id . '"><i class="fas fa-pen"></i> Edit</a>';
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);
            }

            $checkpresensi = DB::table('presensis')
                ->where('jadwal_id', '=', $jdwlsaatini->id)
                ->where('tanggal', '=', $currentDate)
                ->first();

            return view('guru.presensi', compact('jdwlsaatini', 'siswa', 'checkpresensi'));
        } else {
            if ($currentTime > '15:15:00') {
                return redirect()->route('user.dashboard')->with('failed', 'Mata Pelajaran pada hari ini sudah selesai');
            }
            return redirect()->route('user.dashboard')->with('failed', 'Mata Pelajaran belum waktunya dimulai');
        }
    }
    public function update_presensi_all(Request $request)
    {
        // dd($request->all());
        $presensiId = $request->input('presensi_id');
        $status = $request->input('status');
        $updated = Detail_presensi::where('presensi_id', $presensiId)
            ->update(['status' => $status]);

        return redirect()->back();
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
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            ->where('jadwals.user_id', '=', auth()->id())
            ->where('hari', '=', $dayName)
            ->where('jadwals.jam_mulai', '<=', $currentTime)
            ->where('jadwals.jam_selesai', '>=', $currentTime)
            ->first();
        // dd($jdwlsaatini, $detail_presensi);
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
        // dd($detailPresensi, $jdwlsaatini, $detail_presensi);
        // Check if the detail_presensi record exists
        if ($detailPresensi) {
            // Update the status
            DB::table('detail_presensis')
                ->where('id', $detail_presensi)
                ->update(['status' => $request->input('status')]);

            return redirect()->route('user.presensi.guru')->with('success', 'Status siswa telah diperbaharui');
        } else {
            return redirect()->route('user.presensi.guru')->with('error', 'Siswa tidak terdaftar silahkan hubungi admin');
        }
    }
    public function update_presensi_history(Request $request, $detail_presensi)
    {
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();

        $jdwl = DB::table('jadwals')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('presensis', 'jadwals.id', '=', 'presensis.jadwal_id')
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            ->where('presensis.id', '=', $request->id)
            ->first();

        // dd($jdwl, $request->all(), $detail_presensi);
        // Get the specific detail_presensi record for the student
        $detailPresensi = DB::table('detail_presensis')
            ->join('presensis', 'detail_presensis.presensi_id', '=', 'presensis.id')
            ->join('users', 'detail_presensis.user_id', '=', 'users.id')
            ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
            ->join('kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
            ->where('kelas.id', '=', $jdwl->kelas_id)
            // ->where('presensis.tanggal', '=', $currentDate)
            ->where('presensis.jadwal_id', '=', $jdwl->id)
            ->where('detail_presensis.id', '=', $detail_presensi)
            ->first();
        // dd($detailPresensi, $jdwl, $detail_presensi);
        // Check if the detail_presensi record exists
        if ($detailPresensi) {
            // Update the status
            DB::table('detail_presensis')
                ->where('id', $detail_presensi)
                ->update(['status' => $request->input('status')]);

            return redirect()->back()->with('success', 'Status siswa telah diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Gagal edit');
        }
    }
    public function presensi_edit(Request $request)
    {
        $presensis_id = $request->presensi;
        // Set the locale to Indonesian
        Carbon::setLocale('id');

        // Get the current date and time
        $today = Carbon::now();
        $dayName = $today->locale('id')->translatedFormat('l');
        $currentDate = $today->toDateString();
        $currentTime = $today->toTimeString();

        $jdwl = DB::table('jadwals')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->join('presensis', 'jadwals.id', '=', 'presensis.jadwal_id')
            ->select('jadwals.id', 'jadwals.user_id', 'jadwals.kelas_id', 'jadwals.mapel_id', 'jadwals.hari', 'kode_mapel', 'nama_mapel', 'jam_mulai', 'jam_selesai', 'kelas', 'jenis_kelas')
            ->where('presensis.id', '=', $presensis_id)
            ->first();

        $siswa = DB::table('detail_presensis')
            ->join('presensis', 'detail_presensis.presensi_id', '=', 'presensis.id')
            ->join('users', 'detail_presensis.user_id', '=', 'users.id')
            ->join('user_kelas', 'user_kelas.user_id', '=', 'users.id')
            ->join('kelas', 'user_kelas.kelas_id', '=', 'kelas.id')
            ->where('presensis.id', '=', $presensis_id)
            ->get(['detail_presensis.id', 'users.nomor_induk', 'user_kelas.user_id', 'users.name', 'detail_presensis.status']);

        // dd($siswa, $jdwl, $request->all());
        if ($request->ajax()) {
            return DataTables::of($siswa)
                ->addColumn('name', function ($siswa) {
                    return $siswa->nomor_induk . ' - ' . $siswa->name;
                })
                ->addColumn('status', function ($siswa) {
                    return $siswa->status;
                })
                ->addColumn('aksi', function ($siswa) {
                    return '<a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-presensi-edit-history' . $siswa->id . '"><i class="fas fa-pen"></i> Edit</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('guru.presensi_edit', compact('jdwl', 'siswa', 'presensis_id'));
    }
    public function check_face(Request $request)
    {
        $response = Http::post(env("API_URL"), $request->only('image'));

        if ($response->successful()) {
            $responseData = $response->json();

            $value = Session::get('label');
            Carbon::setLocale('id');

            $today = Carbon::now();
            $dayName = $today->locale('id')->translatedFormat('l');
            $currentDate = $today->toDateString();
            $currentTime = $today->toTimeString();

            $labels = [];
            foreach ($responseData as $data) {
                if (isset($data['label'])) {
                    $labels[] = $data['label'];
                }
            }

            if (!empty($labels)) {
                $label = $labels[0];
                if ($label === Session::get('nomor_induk')) {
                    $updatePresensi = DB::table('detail_presensis')
                        ->join('presensis', 'detail_presensis.presensi_id', '=', 'presensis.id')
                        ->join('jadwals', 'presensis.jadwal_id', '=', 'jadwals.id')
                        ->join('users', 'detail_presensis.user_id', '=', 'users.id')
                        ->where('users.nomor_induk', '=', $label)
                        ->where('presensis.tanggal', '=', $currentDate)
                        ->where('jadwals.jam_mulai', '<=', $currentTime)
                        ->where('jadwals.jam_selesai', '>=', $currentTime)
                        ->select('detail_presensis.id', 'presensis.id as presensi_id', 'users.name', 'detail_presensis.status')
                        ->first();

                    if ($updatePresensi) {
                        if ($updatePresensi->status !== 'H') {
                            return redirect()->route('user.presensi.siswa')
                                ->with('label', $label)
                                ->with('detail_presensi_id', $updatePresensi->id)
                                ->with('presensi_id', $updatePresensi->presensi_id)
                                ->with('status', $updatePresensi->status);
                        } else {
                            return redirect()->back()->with('message', 'Status sudah diubah menjadi hadir, oleh guru');
                        }
                    }
                } else {
                    return redirect()->back()->with('message', 'Ulangi scan wajah');
                }
            } else {
                return redirect()->back()->with(
                    'message',
                    'Tidak ada label ditemukan dalam response data.'
                );
            }
        } else {
            return redirect()->back()->with(
                'message',
                'Perbaiki posisi kamera'
            );
        }
    }

    public function presensi_validasi(Request $request)
    {
        $nomor_induk = $request->input('nomor_induk');
        $presensis_id = $request->input('presensis_id');
        $detail_presensis_id = $request->input('detail_presensi_id');
        $status = $request->input('detail_presensis_status');
        $user = DB::table('detail_presensis')
            ->join('users', 'detail_presensis.user_id', '=', 'users.id')
            ->where('users.nomor_induk', $nomor_induk)
            // ->where('presensi_id', '=', $presensis_id)
            ->where('detail_presensis.id', '=', $detail_presensis_id)
            ->select('detail_presensis.*')
            ->first();
        if ($user) {
            Detail_presensi::whereId($user->id)
                ->where('detail_presensis.id', '=', $detail_presensis_id)->update(['status' => $status]);
            $message = "Berhasil melakukan presensi";
        } else {
            $message = "Siswa tidak terdaftar dikelas";
        }

        return redirect()->back()->with('message', $message);
    }
}
