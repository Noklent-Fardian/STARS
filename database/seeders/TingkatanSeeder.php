<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TingkatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_tingkatans')->insert([
            [
                'tingkatan_nama' => 'Internasional',
                'tingkatan_point' => 1000,
                'tingkatan_visible' => true,
            ],
            [
                'tingkatan_nama' => 'Nasional',
                'tingkatan_point' => 750,
                'tingkatan_visible' => true,
            ],
            [
                'tingkatan_nama' => 'Provinsi',
                'tingkatan_point' => 500,
                'tingkatan_visible' => true,
            ],
            [
                'tingkatan_nama' => 'Kota/Kabupaten',
                'tingkatan_point' => 250,
                'tingkatan_visible' => true,
            ],
            [
                'tingkatan_nama' => 'Kecamatan',
                'tingkatan_point' => 100,
                'tingkatan_visible' => true,
            ],
        ]);
    }
}
