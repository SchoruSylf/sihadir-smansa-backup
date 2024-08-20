<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nomor_induk'       => '000000000',
            'name'              => 'admin',
            'role'              => '1',
            'jenis_kelamin'     => 'P',
            'email'             => 'admin@gmail.com',
            'password'          => Hash::make('admin')
        ]);
        User::create([
            'nomor_induk'       => '111111111',
            'name'              => 'guru',
            'role'              => '2',
            'jenis_kelamin'     => 'L',
            'email'             => 'guru@gmail.com',
            'password'          => Hash::make('guru')
        ]);
        User::create([
            'nomor_induk'       => '222222222',
            'name'              => 'siswa',
            'role'              => '3',
            'jenis_kelamin'     => 'P',
            'email'             => 'siswa@gmail.com',
            'password'          => Hash::make('siswa')
        ]);
    }
}
