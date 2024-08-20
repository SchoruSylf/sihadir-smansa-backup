<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUserDummy implements WithHeadings
{
    public function headings(): array
    {
        return ['Nomor Induk', 'Name', 'Email', 'Role', 'Status','Jenis Kelamin'];
    }
}
