<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $ke = 1;
        foreach ($collection as $row) {
            if ($ke > 1) {
                $nomor_induk = $row[0];
                $email = $row[2];
                switch ($row[3]) {
                    case 1:
                        $role = '1';
                        $pass = Hash::make('admin');
                        break;
                    case 2:
                        $role = '2';
                        $pass = Hash::make('guru');
                        break;
                    case 3:
                        $role = '3';
                        $pass = Hash::make('siswa');
                        break;
                    default:
                        $role = '3';
                        $pass = Hash::make('siswa');
                }
                // Periksa apakah nomor_induk atau email sudah ada di database
                $existingUser = DB::table('users')
                    ->where('nomor_induk', $nomor_induk)
                    ->orWhere('email', $email)
                    ->first();

                if (!$existingUser) {
                    $data['nomor_induk']    = $nomor_induk;
                    $data['name']           = $row[1];
                    $data['role']           = $role;
                    $data['status']         = $row[4];
                    $data['email']          = $email;
                    $data['password']       = $pass;

                    User::create($data);
                }
            }

            $ke++;
        }
    }
}
