<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUserKelas implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return ['Nomor Induk','Name'];
    }
}
