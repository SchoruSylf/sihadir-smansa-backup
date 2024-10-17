<?php

namespace App\Imports;

use App\Models\Jadwal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class JadwalImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $ke = 1;

        foreach ($collection as $row) {
            if ($ke > 1) { // Skip the header row
                $hari = $row[0];
                $kelas = $row[1];
                $mapel = $row[2];
                $guru = $row[3];
                $jam_mulai = $row[4];
                $jam_selesai = $row[5];

                // Extract kelas level and name
                $jenisKelas = explode(' ', $kelas, 2);
                $kelas_level = $jenisKelas[0]; // e.g., "10"
                $kelas_name = isset($jenisKelas[1]) ? $jenisKelas[1] : '';

                // Get kelas id
                $id_kelas = DB::table('kelas')
                    ->where('kelas', $kelas_level)
                    ->where('jenis_kelas', $kelas_name)
                    ->pluck('id')
                    ->first();

                // Check if the schedule already exists
                $existingJadwal = DB::table('jadwals')
                    ->where('hari', $hari)
                    ->where('kelas_id', $id_kelas)
                    ->where('jam_mulai', $jam_mulai)
                    ->where('jam_selesai', $jam_selesai)
                    ->exists(); // Check if any matching records exist

                // Get mapel id
                $existingMapel = DB::table('mata_pelajarans')
                    ->where('kode_mapel', $mapel)
                    ->pluck('id')
                    ->first();

                // Get User id
                $existingUser = DB::table('users')
                    ->where('nomor_induk', $guru)
                    ->pluck('id')
                    ->first();

                // Insert new jadwal if it doesn't exist and the mapel is valid
                if (!$existingJadwal && $existingMapel) {
                    $jadwalData = [
                        'user_id'    => $existingUser,
                        'mapel_id'   => $existingMapel,
                        'kelas_id'   => $id_kelas,
                        'hari'       => $hari,
                        'jam_mulai'  => $jam_mulai,
                        'jam_selesai' => $jam_selesai,
                    ];

                    // Create the jadwal record
                    Jadwal::create($jadwalData);

                    // Optional: Logging for debug purposes
                    Log::info("Jadwal created for kelas ID $id_kelas, mapel ID $existingMapel on $hari from $jam_mulai to $jam_selesai.");
                }

                // Optional: You can log or debug here if needed
                // dd($id_kelas, "-", $existingJadwal, "-", $existingMapel);
            }

            $ke++; // Increment row count
        }
    }
}
