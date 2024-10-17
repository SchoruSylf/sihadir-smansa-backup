<?php

namespace App\Http\Controllers;

use App\Imports\JadwalImport;
use App\Imports\SiswaImport;
use App\Imports\UserKelasImport;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mata_pelajaran;
use App\Models\User;
use App\Models\User_kelas;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class InputController extends Controller
{
    // USER
    public function user_read(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('nomor_induk', function ($data) {
                    return $data->nomor_induk;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('role', function ($data) {
                    return $data->role;
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
                })
                ->addColumn('aksi', function ($data) {
                    // Access `id` here to create dynamic links or buttons
                    return '<a href="#" class="edit btn btn-primary mb-2" name="edit" id="' . $data->id . '" ><i class="fas fa-pen"></i> Edit</a>
                            <a href="#" class="btn btn-danger delete mb-2" name="delete" id="' . $data->id . '" ><i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('admin.input_user');

        // if ($request->ajax()) {
        //     $data = User::query()
        //         ->select('id', 'nomor_induk', 'name', 'status', 'email', 'role');
        //     return DataTables::of($data)
        //         ->addColumn('nomor_induk', function ($data) {
        //             return $data->nomor_induk;
        //         })
        //         ->addColumn('name', function ($data) {
        //             return $data->name;
        //         })
        //         ->addColumn('email', function ($data) {
        //             return $data->email;
        //         })
        //         ->addColumn('role', function ($data) {
        //             return $data->role;
        //         })
        //         ->addColumn('status', function ($data) {
        //             return $data->status;
        //         })
        //         ->addColumn('aksi', function ($data) {
        //             // Access `id` here to create dynamic links or buttons
        //             return '<a href="#" class="edit btn btn-primary  mb-2" data-toggle="modal" data-target="#modal-update-user' . $data->id . '"><i class="fas fa-pen"></i> Edit</a>
        //                     <a href="#" class="btn btn-danger delete mb-2" data-toggle="modal" data-target="#modal-delete-user' . $data->id . '"><i class="fas fa-trash-alt"></i> Hapus</a>';
        //         })
        //         ->rawColumns(['aksi']) // Important to render HTML in the action column
        //         ->make(true);
        // }

        // // Retrieve all users with the necessary columns
        // $data = User::select('id', 'nomor_induk', 'name', 'status', 'jenis_kelamin', 'email', 'role')->get();

        // return view('admin.input_user', compact('data'));
    }

    public function user_input(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'nomor_induk' => 'required',
            'name' => 'required',
            'role' => 'required',
            'status' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        // if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['nomor_induk']    = $request->nomor_induk;
        $data['name']           = $request->name;
        $data['role']           = $request->role;
        $data['status']         = $request->status;
        $data['jenis_kelamin']  = $request->jenis_kelamin;
        $data['email']          = $request->email;
        $data['password']       = Hash::make($request->password);
        User::create($data);
        // dd($data);
        // return redirect()->route('user.user.read');

        // return view('admin.input_user');
        return response()->json(['success' => 'Data Pengguna berhasil ditambahkan.']);
    }
    public function user_input_mass(Request $request)
    {
        Excel::import(new SiswaImport(), $request->file('filexlsx'));
        return redirect()->route('user.user.read');
    }

    public function user_input_dataset(Request $request)
    {
        $client = new Client();
        $response = $client->post('http://localhost:5000/process-data', [
            'json' => [
                'csv_file_path' => '/path/to/your/csvfile.csv',
                // Add other necessary parameters
            ]
        ]);

        $responseData = json_decode($response->getBody(), true);

        return response()->json($responseData);
    }

    public function user_edit($id)
    {
        if (request()->ajax()) {
            $data = User::findOrFail($id);
            return response()->json(['result' => $data]);
        }
        // $edit_user = User::find($id);
        // return redirect()->route('user.user.read');
    }
    public function user_update(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'nomor_induk' => 'required',
            'name' => 'required',
            'role' => 'required',
            'status' => 'required',
            'email' => 'required|email',
            'password' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        // if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // if ($validator->fails()) return response()->json(['fail' => 'Data updated failed.']);

        $data['nomor_induk']    = $request->nomor_induk;
        $data['name']           = $request->name;
        $data['role']           = $request->role;
        $data['status']         = $request->status;
        $data['email']          = $request->email;
        if ($request->password) {
            $data['password']       = Hash::make($request->password);
        }
        User::whereId($request->hidden_id)->update($data);
        // return redirect()->route('user.user.read');
        // return response()->json(['data request' => $request->all()]);
        return response()->json(['success' => 'Data berhasil diperbarui.']);
        // }
    }
    public function user_delete($id)
    {
        $user_delete = User::find($id);
        if ($user_delete) {
            $user_delete->delete();
        }
        return redirect()->route('user.user.read');
    }

    // KELAS 
    public function kelas_read(Request $request)
    {
        if ($request->ajax()) {
            $data = Kelas::query()->get();
            return DataTables::of($data)
                ->addColumn('kelas', function ($data) {
                    return $data->kelas;
                })
                ->addColumn('jenis_kelas', function ($data) {
                    return $data->jenis_kelas;
                })
                ->addColumn('aksi', function ($data) {
                    return '<a href="' . route('user.kelas.read_user', ['id_kelas' => $data->id]) . '" class="btn btn-primary mb-2"><i class="fas fa-user"></i> Tambah Siswa</a>
                            <a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-update-kelas' . $data->id . '"><i class="fas fa-pen"></i> Edit</a>
                            <a href="#" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-delete-kelas' . $data->id . '"><i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        $data = Kelas::all();
        return view('admin.input_kelas', compact('data'));
    }
    public function kelas_input(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'kelas'         => 'required',
            'jenis_kelas'   => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['kelas']          = $request->kelas;
        $data['jenis_kelas']    = $request->jenis_kelas;

        Kelas::create($data);
        return redirect()->route('user.kelas.read');
    }
    public function kelas_update(Request $request, $id)
    {
        $validator = FacadesValidator::make($request->all(), [
            'kelas'         => 'required',
            'jenis_kelas'   => 'required'
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data_kelas['kelas'] = $request->kelas;
        $data_kelas['jenis_kelas'] = $request->jenis_kelas;
        Kelas::whereId($id)->update($data_kelas);
        return redirect()->route('user.kelas.read');
    }
    public function kelas_delete($id)
    {
        $kelas_delete = Kelas::find($id);
        if ($kelas_delete) {
            $kelas_delete->delete();
        }
        return redirect()->route('user.kelas.read');
    }
    public function kelas_read_user(Request $request, $id_kelas)
    {
        if ($request->ajax()) {
            $userKelas = User_kelas::with(['user', 'kelas'])
                ->where('kelas_id', $id_kelas)
                ->get();
            return DataTables::of($userKelas)
                ->addColumn('nomor_induk', function ($userKelas) {
                    return $userKelas->user->nomor_induk;
                })
                ->addColumn('name', function ($userKelas) {
                    return $userKelas->user->name;
                })
                ->addColumn('email', function ($userKelas) {
                    return $userKelas->user->email;
                })
                ->addColumn('status', function ($userKelas) {
                    return $userKelas->user->status;
                })
                ->addColumn('aksi', function ($userKelas) {
                    return '<a href="#" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-kelas-delete-user' . $userKelas->id . '"><i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        $userKelas = Kelas::find($id_kelas);
        $User = User_kelas::all();
        $user = User::where('role', '=', '3')->get();
        $user = User_kelas::with(['user', 'kelas'])
            ->where('kelas_id', $id_kelas)
            ->orWhere('role', '=', '3')
            ->latest();

        return view('admin.input_userkelas', compact('userKelas', 'User', 'user'));
    }
    public function kelas_read_selector_user(Request $request, $id_kelas)
    {
        $existingStudentIds = DB::table('user_kelas')
            ->where('kelas_id', $id_kelas)
            ->pluck('user_id');

        $users = User::where('role', '=', '3')
            ->where(function ($query) use ($request) {
                if ($search = $request->input('q')) {
                    $query->where('nomor_induk', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%");
                }
            })
            ->whereNotIn('id', $existingStudentIds)
            ->paginate(10);

        return response()->json($users);
    }
    public function kelas_input_user(Request $request, $id_kelas)
    {
        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:users,id'
        ]);

        $studentIds = $request->students;
        foreach ($studentIds as $studentId) {
            DB::table('user_kelas')->insert([
                'kelas_id' => $id_kelas,
                'user_id' => $studentId,
            ]);
        }

        return redirect()->back()->with('success', 'Students added to class successfully.');
    }
    public function kelas_input_user_mass(Request $request, $id_kelas)
    {
        Excel::import(new UserKelasImport($id_kelas), $request->file('filexlsx'));

        return redirect()->route('user.kelas.read_user', [$id_kelas]);
    }
    public function kelas_delete_user($id_kelas, $id_userKelas)
    {
        // Check if rows were deleted
        DB::table('user_kelas')
            ->where('kelas_id', '=', $id_kelas)
            ->where('id', '=', $id_userKelas)
            ->delete();
        return redirect()->back()->with('success', 'Students added to class successfully.');
    }

    // MATA PELAJARAN
    public function mapel_read(Request $request)
    {
        if ($request->ajax()) {
            $mapel = Mata_pelajaran::query()->select('id', 'kode_mapel', 'nama_mapel')->get();

            return DataTables::of($mapel)
                ->addColumn('kode_mapel', function ($mapel) {
                    return $mapel->kode_mapel;
                })
                ->addColumn('nama_mapel', function ($mapel) {
                    return $mapel->nama_mapel;
                })
                ->addColumn('aksi', function ($mapel) {
                    return '<a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-update-mapel' . $mapel->id . '"><i class="fas fa-pen"></i> Edit</a>
                            <a href="#" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-delete-mapel' . $mapel->id . '"><i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        $mapels = Mata_pelajaran::all(); // Fetch all mapel records
        return view('admin.input_matapelajaran', compact('mapels'));
    }
    public function mapel_input(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'kode_mapel' => 'required',
            'nama_mapel' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        $data['kode_mapel']    = $request->kode_mapel;
        $data['nama_mapel']    = $request->nama_mapel;

        Mata_pelajaran::create($data);
        return redirect()->route('user.mapel.read');
    }
    public function mapel_update(Request $request, $id_mapel)
    {
        $validator = FacadesValidator::make($request->all(), [
            'kode_mapel' => 'required',
            'nama_mapel' => 'required'
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data_mapel['kode_mapel'] = $request->kode_mapel;
        $data_mapel['nama_mapel'] = $request->nama_mapel;
        Mata_pelajaran::whereId($id_mapel)->update($data_mapel);
        return redirect()->route('user.mapel.read');
    }
    public function mapel_delete($id_mapel)
    {
        $mapel_delete = Mata_pelajaran::find($id_mapel);
        if ($mapel_delete) {
            $mapel_delete->delete();
        }
        return redirect()->back()->with('success', 'Students added to class successfully.');
    }
    // JADWAL
    public function jadwal_read(Request $request)
    {
        $jadwal = DB::table('jadwals')
            ->join('users', 'jadwals.user_id', '=', 'users.id')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->where('users.role', '=', '2')
            ->select(
                'jadwals.id',
                'hari',
                DB::raw("TIME_FORMAT(jam_mulai, '%H:%i') as jam_mulai"), // Format jam_mulai to hh:mm
                DB::raw("TIME_FORMAT(jam_selesai, '%H:%i') as jam_selesai"), // Format jam_selesai to hh:mm
                'mata_pelajarans.id as mapel_id',
                'mata_pelajarans.kode_mapel',
                'mata_pelajarans.nama_mapel',
                'kelas.id as kelas_id',
                'kelas.kelas',
                'kelas.jenis_kelas',
                'users.id as user_id',
                'users.name'
            )
            ->get();

        if ($request->ajax()) {
            return DataTables::of($jadwal)
                ->addColumn('hari', function ($jadwal) {
                    return $jadwal->hari;
                })
                ->addColumn('waktu', function ($jadwal) {
                    return $jadwal->jam_mulai . '  -  ' . $jadwal->jam_selesai;
                })
                ->addColumn('kelas', function ($jadwal) {
                    return $jadwal->kelas . ' ' . $jadwal->jenis_kelas;
                })
                ->addColumn('kode_mapel', function ($jadwal) {
                    return $jadwal->kode_mapel;
                })
                ->addColumn('nama_mapel', function ($jadwal) {
                    return $jadwal->nama_mapel;
                })
                ->addColumn('name', function ($jadwal) {
                    return $jadwal->name;
                })
                ->addColumn('aksi', function ($jadwal) {
                    return '<a href="#" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-update-jadwal' . $jadwal->id . '"><i class="fas fa-pen"></i> Edit</a>
                        <a href="#" class="btn btn-danger mb-2" data-toggle="modal" data-target="#modal-delete-jadwal' . $jadwal->id . '"><i class="fas fa-trash-alt"></i> Hapus</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        // Return the view with the $jadwal data
        return view('admin.input_jadwal', compact('jadwal'));
    }

    public function jadwal_read_selector_user(Request $request)
    {
        $users = User::where('role', '=', '2')
            ->where(function ($query) use ($request) {
                if ($search = $request->input('q')) {
                    $query->where('nomor_induk', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%");
                }
            })
            ->paginate(10);

        return response()->json($users);
    }
    public function jadwal_read_selector_kelas(Request $request)
    {
        $users = Kelas::where(function ($query) use ($request) {
            if ($search = $request->input('q')) {
                $query->where('kelas', 'LIKE', "%{$search}%")
                    ->orWhere('jenis_kelas', 'LIKE', "%{$search}%");
            }
        })
            ->paginate(10);

        return response()->json($users);
    }
    public function jadwal_read_selector_mapel(Request $request)
    {
        $users = Mata_pelajaran::where(function ($query) use ($request) {
            if ($search = $request->input('q')) {
                $query->where('kode_mapel', 'LIKE', "%{$search}%")
                    ->orWhere('nama_mapel', 'LIKE', "%{$search}%");
            }
        })
            ->paginate(10);

        return response()->json($users);
    }
    public function checkSelesai(Request $request)
    {
        $kelas = $request->input('kelas');
        $hari = $request->input('hari');
        $jam_mulai = $request->input('jam_mulai');
        // dd($kelas);
        // Query the database to find schedules that conflict with the selected class, day, and start time
        $unavailableTimes = DB::table('jadwals')
            ->where('kelas_id', "=", $kelas)
            ->where('hari', $hari)
            ->where('jam_mulai', $jam_mulai)
            ->pluck('jam_selesai');
        // dd($unavailableTimes);
        // Return the unavailable jam_selesai times as a JSON response
        return response()->json($unavailableTimes);
        // $hari = $request->get('hari');
        // $schedule = Jadwal::where('hari', $hari)->get();

        // return response()->json($schedule);
    }
    public function jamTerdaftar(Request $request)
    {
        // $hari = $request->input('hari');

        // // Fetch unavailable times for the selected day
        // $jadwals = DB::table('jadwals')
        //     ->where('hari', '=', $hari)
        //     ->get(['jam_mulai', 'jam_selesai']);
        // // dd($jadwals);
        // return response()->json($jadwals);
        $hari = $request->input('hari');
        $kelas = $request->input('kelas');
        // dd($kelas);
        // Fetch unavailable times for the selected day
        $jadwals = DB::table('jadwals')
            ->where('hari', '=', $hari)
            ->where('kelas_id', "=", $kelas)
            ->get('jam_mulai');

        // Format the times to hh:mm
        $jadwals = $jadwals->map(function ($jadwal) {
            $jadwal->jam_mulai = \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->jam_mulai)->format('H:i');
            // $jadwal->jam_selesai = \Carbon\Carbon::createFromFormat('H:i:s', $jadwal->jam_selesai)->format('H:i');
            return $jadwal;
        });
        // $kelas = $request->input('kelas');
        // dd($kelas);
        // $kelas = DB::table('kelas')
        // Return the formatted times as JSON
        return response()->json($jadwals);
    }
    public function jadwal_input(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'hari' => 'required',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'kelas' => 'required',
            'mapel' => 'required',
            'guru' => 'required',
        ]);
        // if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $jadwal['hari']         = $request->hari;
        $jadwal['user_id']      = $request->guru;
        $jadwal['mapel_id']     = $request->mapel;
        $jadwal['kelas_id']     = $request->kelas;
        $jadwal['jam_mulai']    = $request->jam_mulai;
        $jadwal['jam_selesai']  = $request->jam_selesai;
        Jadwal::create($jadwal);
        return redirect()->back()->with('success', 'Students added to class successfully.');

        // return response()->json(['success' => 'Jadwal berhasil ditambahkan.']);
    }
    public function jadwal_input_mass(Request $request)
    {
        Excel::import(new JadwalImport(), $request->file('filexlsx'));
        // dd($request);
        return redirect()->route('user.jadwal.read');
    }
    public function jadwal_update(Request $request, $id_jadwal)
    {
        $jadwal = DB::table('jadwals')
            ->join('users', 'jadwals.user_id', '=', 'users.id')
            ->join('mata_pelajarans', 'jadwals.mapel_id', '=', 'mata_pelajarans.id')
            ->join('kelas', 'jadwals.kelas_id', '=', 'kelas.id')
            ->where('users.role', '=', '2')
            ->where('jadwals.id', '=', $id_jadwal)
            ->select('jadwals.id', 'hari', 'jam_mulai', 'jam_selesai', 'mata_pelajarans.id as mapel_id', 'mata_pelajarans.kode_mapel', 'mata_pelajarans.nama_mapel', 'kelas.id as kelas_id', 'kelas.kelas', 'kelas.jenis_kelas', 'users.id as user_id', 'users.name')
            ->first();

        // dd($request->all());
        $validator = FacadesValidator::make($request->all(), [
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            // 'kelas' => 'required',
            // 'mapel' => 'required',
            // 'guru' => 'required',
        ]);
        // dd($jadwal->kelas_id, $request->kelas);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $data_jadwal['hari']         = $request->hari;
        $data_jadwal['user_id']      = $request->guru ?? $jadwal->user_id;
        $data_jadwal['mapel_id']     = $request->mapel ?? $jadwal->mapel_id;
        $data_jadwal['kelas_id']     = $request->kelas ?? $jadwal->kelas_id;
        $data_jadwal['jam_mulai']    = $request->jam_mulai;
        $data_jadwal['jam_selesai']  = $request->jam_selesai;
        Jadwal::whereId($id_jadwal)->update($data_jadwal);
        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
        // return response()->json(['success' => 'Jadwal berhasil diperbarui.']);
    }
    public function jadwal_delete($id_jadwal)
    {
        $jadwal_delete = Jadwal::find($id_jadwal);
        if ($jadwal_delete) {
            $jadwal_delete->delete();
        }
        return redirect()->back();
    }
}
