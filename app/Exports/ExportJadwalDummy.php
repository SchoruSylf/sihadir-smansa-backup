<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportJadwalDummy implements WithHeadings
{
    public function headings(): array
    {
        return ['Hari', 'Kelas', 'Kode Guru', 'Nomor Induk Guru', 'Jam Mulai', 'Jam Selesai'];
    }
}
