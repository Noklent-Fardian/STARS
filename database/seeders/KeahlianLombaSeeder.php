<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeahlianLombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_keahlian_lombas')->insert([
            [
                'lomba_id' => '1',
                'keahlian_id' => '1',
            ],
            [
                'lomba_id' => '1',
                'keahlian_id' => '4',
            ],
            [
                'lomba_id' => '2',
                'keahlian_id' => '2',
            ],
            [
                'lomba_id' => '3',
                'keahlian_id' => '3',
            ],
            [
                'lomba_id' => '3',
                'keahlian_id' => '4',
            ],
        ]);
    }
}
