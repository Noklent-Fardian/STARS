<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BimbinganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_bimbingans')->insert([
            [
                'mahasiswa_id' => 1,
                'dosen_id' => 1,
                'lomba_id' => 1,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 2,
                'dosen_id' => 2,
                'lomba_id' => 1,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 3,
                'dosen_id' => 3,
                'lomba_id' => 2,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 4,
                'dosen_id' => 1,
                'lomba_id' => 2,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 5,
                'dosen_id' => 2,
                'lomba_id' => 3,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 1,
                'dosen_id' => 3,
                'lomba_id' => 3,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 2,
                'dosen_id' => 1,
                'lomba_id' => 3,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 1,
                'dosen_id' => 1,
                'lomba_id' => 1,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 2,
                'dosen_id' => 2,
                'lomba_id' => 1,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 3,
                'dosen_id' => 3,
                'lomba_id' => 2,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 4,
                'dosen_id' => 1,
                'lomba_id' => 2,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 5,
                'dosen_id' => 2,
                'lomba_id' => 3,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 1,
                'dosen_id' => 3,
                'lomba_id' => 3,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 2,
                'dosen_id' => 1,
                'lomba_id' => 3,
                'bimbingan_status' => 'berlangsung',
            ],
            // Additional bimbingan entries
            [
                'mahasiswa_id' => 6,
                'dosen_id' => 2,
                'lomba_id' => 4,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 7,
                'dosen_id' => 3,
                'lomba_id' => 5,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 8,
                'dosen_id' => 1,
                'lomba_id' => 6,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 9,
                'dosen_id' => 2,
                'lomba_id' => 7,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 10,
                'dosen_id' => 3,
                'lomba_id' => 8,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 11,
                'dosen_id' => 1,
                'lomba_id' => 9,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 12,
                'dosen_id' => 2,
                'lomba_id' => 10,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 13,
                'dosen_id' => 3,
                'lomba_id' => 11,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 14,
                'dosen_id' => 1,
                'lomba_id' => 12,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 15,
                'dosen_id' => 2,
                'lomba_id' => 13,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 16,
                'dosen_id' => 3,
                'lomba_id' => 14,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 17,
                'dosen_id' => 1,
                'lomba_id' => 15,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 18,
                'dosen_id' => 2,
                'lomba_id' => 16,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 19,
                'dosen_id' => 3,
                'lomba_id' => 17,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 20,
                'dosen_id' => 1,
                'lomba_id' => 18,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 21,
                'dosen_id' => 2,
                'lomba_id' => 19,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 22,
                'dosen_id' => 3,
                'lomba_id' => 20,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 23,
                'dosen_id' => 1,
                'lomba_id' => 21,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 24,
                'dosen_id' => 2,
                'lomba_id' => 22,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 25,
                'dosen_id' => 3,
                'lomba_id' => 23,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 26,
                'dosen_id' => 1,
                'lomba_id' => 24,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 27,
                'dosen_id' => 2,
                'lomba_id' => 25,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 28,
                'dosen_id' => 3,
                'lomba_id' => 26,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 29,
                'dosen_id' => 1,
                'lomba_id' => 27,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 30,
                'dosen_id' => 2,
                'lomba_id' => 28,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 31,
                'dosen_id' => 3,
                'lomba_id' => 29,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 32,
                'dosen_id' => 1,
                'lomba_id' => 30,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 33,
                'dosen_id' => 2,
                'lomba_id' => 31,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 34,
                'dosen_id' => 3,
                'lomba_id' => 32,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 35,
                'dosen_id' => 1,
                'lomba_id' => 33,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 36,
                'dosen_id' => 2,
                'lomba_id' => 34,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 37,
                'dosen_id' => 3,
                'lomba_id' => 35,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 38,
                'dosen_id' => 1,
                'lomba_id' => 36,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 39,
                'dosen_id' => 2,
                'lomba_id' => 37,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 40,
                'dosen_id' => 3,
                'lomba_id' => 38,
                'bimbingan_status' => 'selesai',
            ],
            // Multiple bimbingan for same student-dosen pairs with different lomba
            [
                'mahasiswa_id' => 1,
                'dosen_id' => 2,
                'lomba_id' => 39,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 2,
                'dosen_id' => 3,
                'lomba_id' => 40,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 3,
                'dosen_id' => 1,
                'lomba_id' => 41,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 4,
                'dosen_id' => 2,
                'lomba_id' => 42,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 5,
                'dosen_id' => 3,
                'lomba_id' => 43,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 6,
                'dosen_id' => 1,
                'lomba_id' => 44,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 7,
                'dosen_id' => 2,
                'lomba_id' => 45,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 8,
                'dosen_id' => 3,
                'lomba_id' => 46,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 9,
                'dosen_id' => 1,
                'lomba_id' => 47,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 10,
                'dosen_id' => 2,
                'lomba_id' => 48,
                'bimbingan_status' => 'selesai',
            ],
            // Recent entries for newer students
            [
                'mahasiswa_id' => 41,
                'dosen_id' => 1,
                'lomba_id' => 1,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 42,
                'dosen_id' => 2,
                'lomba_id' => 2,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 43,
                'dosen_id' => 3,
                'lomba_id' => 3,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 44,
                'dosen_id' => 1,
                'lomba_id' => 4,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 45,
                'dosen_id' => 2,
                'lomba_id' => 5,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 46,
                'dosen_id' => 3,
                'lomba_id' => 6,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 47,
                'dosen_id' => 1,
                'lomba_id' => 7,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 48,
                'dosen_id' => 2,
                'lomba_id' => 8,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 49,
                'dosen_id' => 3,
                'lomba_id' => 9,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 50,
                'dosen_id' => 1,
                'lomba_id' => 10,
                'bimbingan_status' => 'berlangsung',
            ],
            // More diverse combinations
            [
                'mahasiswa_id' => 15,
                'dosen_id' => 3,
                'lomba_id' => 49,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 20,
                'dosen_id' => 2,
                'lomba_id' => 50,
                'bimbingan_status' => 'berlangsung',
            ],
            [
                'mahasiswa_id' => 25,
                'dosen_id' => 1,
                'lomba_id' => 4,
                'bimbingan_status' => 'batal',
            ],
            [
                'mahasiswa_id' => 30,
                'dosen_id' => 3,
                'lomba_id' => 5,
                'bimbingan_status' => 'selesai',
            ],
            [
                'mahasiswa_id' => 35,
                'dosen_id' => 2,
                'lomba_id' => 6,
                'bimbingan_status' => 'berlangsung',
            ],
        ]);
    }
}