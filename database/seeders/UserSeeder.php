<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        DB::table('m_users')->insert([
            [
                'username' => 'admin1',
                'user_password' => Hash::make('admin123'),
                'user_role' => 'Admin',
            ],
            [
                'username' => 'admin2',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Admin',
            ],
            [
                'username' => 'admin3',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Admin',
            ],
            [
                'username' => 'admin4',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Admin',
            ],
            [
                'username' => 'admin5',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Dosen',
            ],
            [
                'username' => 'dosen1',
                'user_password' => Hash::make('dosen123'),
                'user_role' => 'Dosen',
            ],
            [
                'username' => 'dosen2',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Dosen',
            ],
            [
                'username' => 'dosen3',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Dosen',
            ],
            [
                'username' => 'dosen4',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Dosen',
            ],
            [
                'username' => 'dosen5',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Dosen',
            ],
            [
                'username' => 'dosen6',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Dosen',
            ],
            [
                'username' => 'mahasiswa1',
                'user_password' => Hash::make('mahasiswa123'),
                'user_role' => 'Mahasiswa',
            ],
            [
                'username' => 'mahasiswa2',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Mahasiswa',
            ],
            [
                'username' => 'mahasiswa3',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Mahasiswa',
            ],
            [
                'username' => 'mahasiswa4',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Mahasiswa',
            ],
            [
                'username' => 'mahasiswa5',
                'user_password' => Hash::make('12345'),
                'user_role' => 'Mahasiswa',
            ],
        ]);
    }
}

