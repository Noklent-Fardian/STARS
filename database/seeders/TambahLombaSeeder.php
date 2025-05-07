<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TambahLombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_request_tambah_lombas')->insert([

            [
                'mahasiswa_id' => 1,
                'lomba_id' => 1,
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2024-08-30',
            ],
            [
                'mahasiswa_id' => 2,
                'lomba_id' => 1,
                'pendaftaran_status' => 'Ditolak',
                'pendaftaran_tanggal_pendaftaran' => '2024-08-29',
            ],
            [
                'mahasiswa_id' => 3,
                'lomba_id' => 2,
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2025-03-27',
            ],
            [
                'mahasiswa_id' => 4,
                'lomba_id' => 2,
                'pendaftaran_status' => 'Ditolak',
                'pendaftaran_tanggal_pendaftaran' => '2025-03-30',
            ],
            [
                'mahasiswa_id' => 5,
                'lomba_id' => 3,
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2025-05-30',
            ],
            [
                'mahasiswa_id' => 1,
                'lomba_id' => 3,
                'pendaftaran_status' => 'Menunggu',
                'pendaftaran_tanggal_pendaftaran' => '2025-06-01',
            ],
            [
                'mahasiswa_id' => 2,
                'lomba_id' => 3,
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2025-06-01',
            ],
        ]);
    }
}
