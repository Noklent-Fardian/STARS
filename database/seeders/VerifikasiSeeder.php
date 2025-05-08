<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VerifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_verifikasis')->insert([
            [
                'mahasiswa_id' => 1,
                'penghargaan_id' => 1,
                'dosen_id' => 1,
                'admin_id' => 1,
                'verifikasi_admin_status' => 'Diterima',
                'verifikasi_dosen_status' => 'Diterima',
                'verifikasi_admin_keterangan' => 'Valid dan sesuai dokumen',
                'verifikasi_dosen_keterangan' => 'Prestasi bagus',
                'verifikasi_admin_tanggal' => '2024-09-01',
                'verifikasi_dosen_tanggal' => '2024-09-01',
            ],
            [
                'mahasiswa_id' => 2,
                'penghargaan_id' => 2,
                'dosen_id' => 2,
                'admin_id' => 1,
                'verifikasi_admin_status' => 'Ditolak',
                'verifikasi_dosen_status' => 'Diterima',
                'verifikasi_admin_keterangan' => 'Bukti tidak lengkap',
                'verifikasi_dosen_keterangan' => 'Sudah dibimbing dengan baik',
                'verifikasi_admin_tanggal' => '2024-09-02',
                'verifikasi_dosen_tanggal' => '2024-09-02',
            ],
            [
                'mahasiswa_id' => 3,
                'penghargaan_id' => 3,
                'dosen_id' => 3,
                'admin_id' => 1,
                'verifikasi_admin_status' => 'Diterima',
                'verifikasi_dosen_status' => 'Diterima',
                'verifikasi_admin_keterangan' => 'Dokumen lengkap',
                'verifikasi_dosen_keterangan' => 'Layak diverifikasi',
                'verifikasi_admin_tanggal' => '2025-04-01',
                'verifikasi_dosen_tanggal' => '2025-04-01',
            ],
            [
                'mahasiswa_id' => 4,
                'penghargaan_id' => 4,
                'dosen_id' => 1,
                'admin_id' => 1,
                'verifikasi_admin_status' => 'Ditolak',
                'verifikasi_dosen_status' => 'Ditolak',
                'verifikasi_admin_keterangan' => 'Tidak sesuai dengan lomba',
                'verifikasi_dosen_keterangan' => 'Belum lengkap laporan',
                'verifikasi_admin_tanggal' => '2025-04-02',
                'verifikasi_dosen_tanggal' => '2025-04-02',
            ],
        ]);

    }
}
