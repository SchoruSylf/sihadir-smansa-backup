<?php

namespace App\Imports;

use App\Models\User_kelas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserKelasImport implements ToCollection
{
    protected $id_kelas;

    public function __construct($id_kelas)
    {
        $this->id_kelas = $id_kelas;
    }

    public function collection(Collection $collection)
    {
        $ke = 1;

        foreach ($collection as $row) {
            if ($ke > 1) {
                // Check if the user exists by nomor_induk
                $user = DB::table('users')
                    ->where('nomor_induk', '=', $row[0])
                    ->first();

                if ($user) {
                    // Check if the user is already assigned to the class
                    $existingUserKelas = DB::table('user_kelas')
                        ->where('user_id', $user->id)
                        ->where('kelas_id', $this->id_kelas)
                        ->first();

                    // If not already assigned, create the record
                    if (!$existingUserKelas) {
                        $userKelas = [
                            'kelas_id' => $this->id_kelas,
                            'user_id'  => $user->id,
                        ];
                        User_kelas::create($userKelas);
                    }
                }
            }
            $ke++;
        }
    }
}
