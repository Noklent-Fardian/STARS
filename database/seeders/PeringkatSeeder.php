<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PeringkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_peringkats')->insert([
            [
                'peringkat_nama' => 'Juara 1',
                'peringkat_bobot' => 2.0,
            ],
            [
                'peringkat_nama' => 'Juara 2',
                'peringkat_bobot' => 1.5,
            ],
            [
                'peringkat_nama' => 'Juara 3',
                'peringkat_bobot' => 1.2,
            ],
            [
                'peringkat_nama' => 'Harapan 1',
                'peringkat_bobot' => 0.9,
            ],
            [
                'peringkat_nama' => 'Harapan 2',
                'peringkat_bobot' => 0.7,
            ],
            [
                'peringkat_nama' => 'Harapan 3',
                'peringkat_bobot' => 0.5,
            ],
        ]);

    }
}
