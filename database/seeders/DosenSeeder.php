<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Db::table('m_dosens')->insert([
            [
                'user_id' => 6,
                'prodi_id' => 1,
                'keahlian_id' => 1,
                'keahlian_sertifikat' => null,
                'dosen_nama' => 'Dimas Wahyu Wibowo, S.T., M.T.',
                'dosen_nip' => '198410092015041001',
                'dosen_status' => 'Aktif',
                'dosen_gender' => 'Laki-laki',
                'dosen_nomor_telepon' => '08179646264',
                'dosen_photo' => null,
                'dosen_agama' => null,
                'dosen_provinsi' => null,
                'dosen_kota' => null,
                'dosen_kecamatan' => null,
                'dosen_desa' => null,
            ],
            [
                'user_id' => 7,
                'prodi_id' => 1,
                'keahlian_id' => 2,
                'keahlian_sertifikat' => null,
                'dosen_nama' => 'Ade Ismail, S.Kom., M.TI.',
                'dosen_nip' => '199107042019031021',
                'dosen_status' => 'Aktif',
                'dosen_gender' => 'Laki-laki',
                'dosen_nomor_telepon' => '081288012854',
                'dosen_photo' => null,
                'dosen_agama' => null,
                'dosen_provinsi' => null,
                'dosen_kota' => null,
                'dosen_kecamatan' => null,
                'dosen_desa' => null,
            ],
            [
                'user_id' => 8,
                'prodi_id' => 1,
                'keahlian_id' => 3,
                'keahlian_sertifikat' => null,
                'dosen_nama' => 'Eka Larasati Amalia, S.ST., M.T.',
                'dosen_nip' => '198807112015042005',
                'dosen_status' => 'Aktif',
                'dosen_gender' => 'Perempuan',
                'dosen_nomor_telepon' => '081259668854',
                'dosen_photo' => null,
                'dosen_agama' => null,
                'dosen_provinsi' => null,
                'dosen_kota' => null,
                'dosen_kecamatan' => null,
                'dosen_desa' => null,
            ],
            [
                'user_id' => 9,
                'prodi_id' => 1,
                'keahlian_id' => 4,
                'keahlian_sertifikat' => null,
                'dosen_nama' => 'Muhammad Afif Hendrawan, S.Kom., M.T.',
                'dosen_nip' => '199111282019031013',
                'dosen_status' => 'Aktif',
                'dosen_gender' => 'Laki-laki',
                'dosen_nomor_telepon' => '081333501063',
                'dosen_photo' => null,
                'dosen_agama' => null,
                'dosen_provinsi' => null,
                'dosen_kota' => null,
                'dosen_kecamatan' => null,
                'dosen_desa' => null,
            ],
            [
                'user_id' => 10,
                'prodi_id' => 1,
                'keahlian_id' => 5,
                'keahlian_sertifikat' => null,
                'dosen_nama' => 'Retno Damayanti, S.Pd., M.T.',
                'dosen_nip' => '198910042019032023',
                'dosen_status' => 'Aktif',
                'dosen_gender' => 'Perempuan',
                'dosen_nomor_telepon' => '081231661779',
                'dosen_photo' => null,
                'dosen_agama' => null,
                'dosen_provinsi' => null,
                'dosen_kota' => null,
                'dosen_kecamatan' => null,
                'dosen_desa' => null,
            ],
            [
                'user_id' => 11,
                'prodi_id' => 1,
                'keahlian_id' => 6,
                'keahlian_sertifikat' => null,
                'dosen_nama' => 'Rizki Putri Ramadhani, S.S., M.Pd.',
                'dosen_nip' => '199004102019092001',
                'dosen_status' => 'Aktif',
                'dosen_gender' => 'Perempuan',
                'dosen_nomor_telepon' => '081334622521',
                'dosen_photo' => null,
                'dosen_agama' => null,
                'dosen_provinsi' => null,
                'dosen_kota' => null,
                'dosen_kecamatan' => null,
                'dosen_desa' => null,
            ],
        ]);
    }
}
