<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_lombas')->insert([
            [
                'keahlian_id' => 1,
                'tingkatan_id' => 2,
                'semester_id' => 7,
                'lomba_nama' => 'Lomba Frontend Web Design',
                'lomba_penyelenggara' => 'Dicoding',
                'lomba_kategori' => 'Web Design',
                'lomba_tanggal_mulai' => '2024-09-01',
                'lomba_tanggal_selesai' => '2024-09-05',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
            ],
            [
                'keahlian_id' => 2,
                'tingkatan_id' => 3,
                'semester_id' => 8,
                'lomba_nama' => 'Backend API Development Contest',
                'lomba_penyelenggara' => 'PENS',
                'lomba_kategori' => 'Backend Programming',
                'lomba_tanggal_mulai' => '2025-04-10',
                'lomba_tanggal_selesai' => '2025-04-15',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
            ],
            [
                'keahlian_id' => 3,
                'tingkatan_id' => 2,
                'semester_id' => 8,
                'lomba_nama' => 'Indie Game Development Jam',
                'lomba_penyelenggara' => 'GameDev Indonesia',
                'lomba_kategori' => 'Game Developer',
                'lomba_tanggal_mulai' => '2025-03-01',
                'lomba_tanggal_selesai' => '2025-03-10',
                'lomba_link_pendaftaran' => '',
                'lomba_link_poster' => '',
            ],
        ]);
    }
}
