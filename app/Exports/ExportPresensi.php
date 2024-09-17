<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportPresensi implements FromCollection, WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array
    {
        // Get distinct dates for headers
        $dates = DB::table('presensis')
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal')
            ->toArray();
        // dd($dates);
        // Return headers including dynamic dates
        return array_merge(
            ['Nama', 'NIS', 'Jenis Kelamin', 'Kelas', 'Mata Pelajaran'],
            $dates,
            ['% Kehadiran'] // Ensure '% Kehadiran' is included at the end
        );
    }

    public function collection()
    {
        // Prepare dynamic columns for each unique date
        $dates = DB::table('presensis')
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal')
            ->toArray();

        $columnsSql = implode(
            ', ',
            array_map(function ($date) {
                return "MAX(CASE WHEN p.tanggal = '$date' THEN dp.status END) AS `$date`";
            }, $dates)
        );

        // Construct the full query
        $query = "
            SELECT u.name, 
                u.nomor_induk, 
                u.jenis_kelamin, 
                CONCAT(k.kelas, k.jenis_kelas) AS kelas, 
                mp.nama_mapel, 
                $columnsSql,
                (SUM(CASE WHEN dp.status = 'H' THEN 1 ELSE 0 END) * 100.0 / COUNT(DISTINCT p.tanggal)) AS persen_kehadiran
            FROM detail_presensis dp
            JOIN presensis p ON dp.presensi_id = p.id
            JOIN users u ON dp.user_id = u.id
            JOIN jadwals j ON p.jadwal_id = j.id
            JOIN kelas k ON j.kelas_id = k.id
            JOIN mata_pelajarans mp ON j.mapel_id = mp.id
            GROUP BY u.name, u.nomor_induk, u.jenis_kelamin, k.kelas, k.jenis_kelas, mp.nama_mapel
            ORDER BY mp.nama_mapel, u.id;;
        ";

        // Execute the query
        $results = DB::select($query);

        // Convert results to a collection
        return collect($results);
    }
}
