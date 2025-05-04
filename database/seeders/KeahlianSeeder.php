<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_keahlians')->insert([
            [
                'keahlian_nama' => 'Frontend Developer',
                'keahlian_sertifikat' => '',
            ],
            [
                'keahlian_nama' => 'Backend Developer',
                'keahlian_sertifikat' => '',
            ],
            [
                'keahlian_nama' => 'Game Developer',
                'keahlian_sertifikat' => '',
            ],
            [
                'keahlian_nama' => 'UI/UX Designer',
                'keahlian_sertifikat' => '',
            ],
            [
                'keahlian_nama' => 'Software Tester (QA)',
                'keahlian_sertifikat' => '',
            ],
        ]);
    }
}
