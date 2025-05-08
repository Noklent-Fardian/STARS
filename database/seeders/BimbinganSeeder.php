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
        ]);
    }
}
