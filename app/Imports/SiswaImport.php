<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection
{
    public function __construct()
    {
        // Extend execution time and memory limit
        set_time_limit(300); // 5 minutes
        ini_set('memory_limit', '512M');
    }
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
                $jenis_kelamin = strtoupper(trim($row[5])); // Trim spaces and convert to uppercase

                // Log the current row being processed
                Log::info("Processing Row $ke: nomor_induk = $nomor_induk, email = $email, jenis_kelamin = $jenis_kelamin");

                // Determine role and password
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
                        break;
                }

                // Check if nomor_induk or email already exists in the database
                $existingUser = DB::table('users')
                    ->where('nomor_induk', $nomor_induk)
                    ->orWhere('email', $email)
                    ->first();

                if (!$existingUser) {
                    $userData = [
                        'nomor_induk'    => $nomor_induk,
                        'name'           => $row[1],
                        'role'           => $role,
                        'status'         => $row[4],
                        'jenis_kelamin'  => $jenis_kelamin,
                        'email'          => $email,
                        'password'       => $pass,
                    ];

                    User::create($userData);
                }
            }
            $ke++;
        }
    }
}
