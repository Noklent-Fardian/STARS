<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_prodis')->insert(
            [
                [
                    'prodi_nama' => 'D-IV Teknik Informatika',
                    'prodi_kode' => 'D4-TI',
                ],
                [
                    'prodi_nama' => 'D-IV Sistem Informasi Bisnis',
                    'prodi_kode' => 'D4-SIB',
                ],
                [
                    'prodi_nama' => 'D-II Pengembangan Piranti Lunak Situs',
                    'prodi_kode' => 'D-II-PPLS',
                ],
            ]
        );
    }
}
