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
                'lomba_nama' => 'Lomba Frontend Web Design',
                'lomba_penyelenggara' => 'Dicoding',
                'lomba_kategori' => 'Akademik',
                'lomba_tanggal_mulai' => '2024-09-01',
                'lomba_tanggal_selesai' => '2024-09-05',
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2024-08-30',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
                'lomba_tingkatan_id' => 2,
                'created_at' => '2024-08-01',
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 2,
                'lomba_id' => 1,
                'lomba_nama' => 'Lomba Frontend Web Design',
                'lomba_penyelenggara' => 'Dicoding',
                'lomba_kategori' => 'Akademik',
                'lomba_tanggal_mulai' => '2024-09-01',
                'lomba_tanggal_selesai' => '2024-09-05',
                'pendaftaran_status' => 'Ditolak',
                'pendaftaran_tanggal_pendaftaran' => '2024-08-29',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
                'lomba_tingkatan_id' => 2,
                'created_at' => '2024-08-02',
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 3,
                'lomba_id' => 2,
                'lomba_nama' => 'Backend API Development Contest',
                'lomba_penyelenggara' => 'PENS',
                'lomba_kategori' => 'Akademik',
                'lomba_tanggal_mulai' => '2025-04-10',
                'lomba_tanggal_selesai' => '2025-04-15',
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2025-03-27',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
                'lomba_tingkatan_id' => 3,
                'created_at' => '2025-03-02',
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 4,
                'lomba_id' => 2,
                'lomba_nama' => 'Backend API Development Contest',
                'lomba_penyelenggara' => 'PENS',
                'lomba_kategori' => 'Akademik',
                'lomba_tanggal_mulai' => '2025-04-10',
                'lomba_tanggal_selesai' => '2025-04-15',
                'pendaftaran_status' => 'Ditolak',
                'pendaftaran_tanggal_pendaftaran' => '2025-03-30',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
                'lomba_tingkatan_id' => 3,
                'created_at' => '2025-03-05',
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 5,
                'lomba_id' => 3,
                'lomba_nama' => 'Indie Game Development Jam',
                'lomba_penyelenggara' => 'GameDev Indonesia',
                'lomba_kategori' => 'Non-Akademik',
                'lomba_tanggal_mulai' => '2025-07-01',
                'lomba_tanggal_selesai' => '2025-07-10',
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2025-05-30',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
                'lomba_tingkatan_id' => 2,
                'created_at' => '2025-05-10',
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 1,
                'lomba_id' => 3,
                'lomba_nama' => 'Indie Game Development Jam',
                'lomba_penyelenggara' => 'GameDev Indonesia',
                'lomba_kategori' => 'Non-Akademik',
                'lomba_tanggal_mulai' => '2025-07-01',
                'lomba_tanggal_selesai' => '2025-07-10',
                'pendaftaran_status' => 'Menunggu',
                'pendaftaran_tanggal_pendaftaran' => '2025-06-01',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
                'lomba_tingkatan_id' => 2,
                'created_at' => '2025-06-10',
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 2,
                'lomba_id' => 3,
                'lomba_nama' => 'Indie Game Development Jam',
                'lomba_penyelenggara' => 'GameDev Indonesia',
                'lomba_kategori' => 'Non-Akademik',
                'lomba_tanggal_mulai' => '2025-07-01',
                'lomba_tanggal_selesai' => '2025-07-10',
                'pendaftaran_status' => 'Diterima',
                'pendaftaran_tanggal_pendaftaran' => '2025-06-01',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
                'lomba_tingkatan_id' => 2,
                'created_at' => '2025-05-20',
                'updated_at' => now(),
            ],
        ]);
    }
}
