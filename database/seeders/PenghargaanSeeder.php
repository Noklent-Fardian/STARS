<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PenghargaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_penghargaans')->insert([
            [
                'mahasiswa_id' => 1,
                'lomba_id' => 1,
                'peringkat_id' => 1,
                'tingkatan_id' => 2,
                'penghargaan_judul' => 'Juara 1 Lomba Frontend Web Design',
                'penghargaan_tempat' => 'Jakarta',
                'penghargaan_url' => '',
                'penghargaan_tanggal_mulai' => '2024-09-01',
                'penghargaan_tanggal_selesai' => '2024-09-05',
                'penghargaan_jumlah_peserta' => 120,
                'penghargaan_jumlah_instansi' => 15,
                'penghargaan_no_surat_tugas' => '',
                'penghargaan_tanggal_surat_tugas' => '2024-08-25',
                'penghargaan_file_surat_tugas' => '',
                'penghargaan_file_sertifikat' => '',
                'penghargaan_file_poster' => '',
                'penghargaan_photo_kegiatan' => '',
                'penghargaan_visible' => true,
            ],
            [
                'mahasiswa_id' => 2,
                'lomba_id' => 2,
                'peringkat_id' => 2,
                'tingkatan_id' => 3,
                'penghargaan_judul' => 'Juara 2 Backend API Development',
                'penghargaan_tempat' => 'Surabaya',
                'penghargaan_url' => '',
                'penghargaan_tanggal_mulai' => '2025-04-10',
                'penghargaan_tanggal_selesai' => '2025-04-15',
                'penghargaan_jumlah_peserta' => 80,
                'penghargaan_jumlah_instansi' => 10,
                'penghargaan_no_surat_tugas' => '',
                'penghargaan_tanggal_surat_tugas' => '2025-04-01',
                'penghargaan_file_surat_tugas' => '',
                'penghargaan_file_sertifikat' => '',
                'penghargaan_file_poster' => '',
                'penghargaan_photo_kegiatan' => '',
                'penghargaan_visible' => true,
            ],
        ]);
    }
}
