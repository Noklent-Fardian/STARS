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
            [
                'lomba_id' => '4',
                'keahlian_id' => '4',
            ],
            [
                'lomba_id' => '5',
                'keahlian_id' => '11',
            ],
            [
                'lomba_id' => '6',
                'keahlian_id' => '1',
            ],
            [
                'lomba_id' => '6',
                'keahlian_id' => '2',
            ],
            [
                'lomba_id' => '7',
                'keahlian_id' => '1',
            ],
            [
                'lomba_id' => '8',
                'keahlian_id' => '2',
            ],
            [
                'lomba_id' => '9',
                'keahlian_id' => '3',
            ],
            [
                'lomba_id' => '10',
                'keahlian_id' => '3',
            ],
            [
                'lomba_id' => '11',
                'keahlian_id' => '2',
            ],
            [
                'lomba_id' => '12',
                'keahlian_id' => '2',
            ],
            [
                'lomba_id' => '13',
                'keahlian_id' => '2',
            ],
            [
                'lomba_id' => '14',
                'keahlian_id' => '1',
            ],
            [
                'lomba_id' => '15',
                'keahlian_id' => '2',
            ],
            [
                'lomba_id' => '16',
                'keahlian_id' => '1',
            ],
            [
                'lomba_id' => '17',
                'keahlian_id' => '3',
            ],
        ]);
    }
}
