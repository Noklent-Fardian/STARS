<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_semesters')->insert([
            [
                'semester_nama' => 'Ganjil 2021/2022',
                'semester_tahun' => 2021,
                'semester_jenis' => 'Ganjil',
                'semester_aktif' => false,
            ],
            [
                'semester_nama' => 'Genap 2021/2022',
                'semester_tahun' => 2022,
                'semester_jenis' => 'Genap',
                'semester_aktif' => false,
            ],
            [
                'semester_nama' => 'Ganjil 2022/2023',
                'semester_tahun' => 2022,
                'semester_jenis' => 'Ganjil',
                'semester_aktif' => false,
            ],
            [
                'semester_nama' => 'Genap 2022/2023',
                'semester_tahun' => 2023,
                'semester_jenis' => 'Genap',
                'semester_aktif' => false,
            ],
            [
                'semester_nama' => 'Ganjil 2023/2024',
                'semester_tahun' => 2023,
                'semester_jenis' => 'Ganjil',
                'semester_aktif' => false,
            ],
            [
                'semester_nama' => 'Genap 2023/2024',
                'semester_tahun' => 2024,
                'semester_jenis' => 'Genap',
                'semester_aktif' => false,
            ],
            [
                'semester_nama' => 'Ganjil 2024/2025',
                'semester_tahun' => 2024,
                'semester_jenis' => 'Ganjil',
                'semester_aktif' => false,
            ],
            [
                'semester_nama' => 'Genap 2024/2025',
                'semester_tahun' => 2025,
                'semester_jenis' => 'Genap',
                'semester_aktif' => true,
            ],
        ]);
    }
}
