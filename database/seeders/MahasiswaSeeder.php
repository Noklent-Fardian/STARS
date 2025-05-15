<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_mahasiswas')->insert([
            [
                'user_id' => '12',
                'prodi_id' => 1,
                'keahlian_id' => '1',
                'semester_id' => '8',
                'mahasiswa_nama' => 'Taufik Dimas Edystara',
                'mahasiswa_nim' => '2341720062',
                'mahasiswa_status' => 'Aktif',
                'mahasiswa_gender' => 'Laki-laki',
                'mahasiswa_angakatan' => '2023',
                'mahasiswa_nomor_telepon' => '085730760115',
                'mahasiswa_photo' => null,
                'mahasiswa_agama' => 'Islam',
                'mahasiswa_provinsi' => '',
                'mahasiswa_kota' => '',
                'mahasiswa_kecamatan' => '',
                'mahasiswa_desa' => '',
                'mahasiswa_visible' => true,
            ],
            [
                'user_id' => '13',
                'prodi_id' => 1,
                'keahlian_id' => '2',
                'semester_id' => '8',
                'mahasiswa_nama' => 'Noklent Fardian Erix',
                'mahasiswa_nim' => '2341720082',
                'mahasiswa_status' => 'Aktif',
                'mahasiswa_gender' => 'Laki-laki',
                'mahasiswa_angakatan' => '2023',
                'mahasiswa_nomor_telepon' => '087866301810',
                'mahasiswa_photo'=>null,
                'mahasiswa_agama' => 'Islam',
                'mahasiswa_provinsi' => '',
                'mahasiswa_kota' => '',
                'mahasiswa_kecamatan' => '',
                'mahasiswa_desa' => '',
                'mahasiswa_visible' => true,
            ],
            [
                'user_id' => '14',
                'prodi_id' => 1,
                'keahlian_id' => '3',
                'semester_id' => '8',
                'mahasiswa_nama' => 'Achmad Maulana Hamzah',
                'mahasiswa_nim' => '2341720172',
                'mahasiswa_status' => 'Aktif',
                'mahasiswa_gender' => 'Laki-laki',
                'mahasiswa_angakatan' => '2023',
                'mahasiswa_nomor_telepon' => '082131973378',
                'mahasiswa_photo'=>null,
                'mahasiswa_agama' => 'Islam',
                'mahasiswa_provinsi' => '',
                'mahasiswa_kota' => '',
                'mahasiswa_kecamatan' => '',
                'mahasiswa_desa' => '',
                'mahasiswa_visible' => true,
            ],
            [
                'user_id' => '15',
                'prodi_id' => 1,
                'keahlian_id' => '4',
                'semester_id' => '8',
                'mahasiswa_nama' => 'Necha Syifa Syafitri',
                'mahasiswa_nim' => '2341720167',
                'mahasiswa_status' => 'Aktif',
                'mahasiswa_gender' => 'Perempuan',
                'mahasiswa_angakatan' => '2023',
                'mahasiswa_nomor_telepon' => '082133236984',
                'mahasiswa_photo'=>null,
                'mahasiswa_agama' => 'Islam',
                'mahasiswa_provinsi' => '',
                'mahasiswa_kota' => '',
                'mahasiswa_kecamatan' => '',
                'mahasiswa_desa' => '',
                'mahasiswa_visible' => true,
            ],
            [
                'user_id' => '16',
                'prodi_id' => 1,
                'keahlian_id' => '5',
                'semester_id' => '8',
                'mahasiswa_nama' => 'Candra Ahmad Dani',
                'mahasiswa_nim' => '2341720187',
                'mahasiswa_status' => 'Aktif',
                'mahasiswa_gender' => 'Laki-laki',
                'mahasiswa_angakatan' => '2023',
                'mahasiswa_nomor_telepon' => '089517032681',
                'mahasiswa_photo' => null,
                'mahasiswa_agama' => 'Islam',
                'mahasiswa_provinsi' => '',
                'mahasiswa_kota' => '',
                'mahasiswa_kecamatan' => '',
                'mahasiswa_desa' => '',
                'mahasiswa_visible' => true,
            ],
        ]);
    }
}
