<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BobotSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_bobots')->insert([
            [
                'kriteria' => 'score',
                'bobot' => 0.4,
            ],
            [
                'kriteria' => 'keahlian_utama',
                'bobot' => 0.3,
            ],
            [
                'kriteria' => 'keahlian_tambahan',
                'bobot' => 0.2,
            ],
            [
                'kriteria' => 'jumlah_lomba',
                'bobot' => 0.1,
            ],
        ]);
    }
}