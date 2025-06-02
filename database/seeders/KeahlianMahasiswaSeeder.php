<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KeahlianMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_keahlian_mahasiswas')->insert([
            [
                'mahasiswa_id' => '1',
                'keahlian_id' => '3',
            ],
            [
                'mahasiswa_id' => '1',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '2',
                'keahlian_id' => '1',
            ],
            [
                'mahasiswa_id' => '2',
                'keahlian_id' => '3',
            ],
            [
                'mahasiswa_id' => '3',
                'keahlian_id' => '1',
            ],
            [
                'mahasiswa_id' => '3',
                'keahlian_id' => '4',
            ],
            [
                'mahasiswa_id' => '4',
                'keahlian_id' => '3',
            ],
            [
                'mahasiswa_id' => '4',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '5',
                'keahlian_id' => '4',
            ],
            [
                'mahasiswa_id' => '5',
                'keahlian_id' => '5',
            ],
            [
                'mahasiswa_id' => '6',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '7',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '8',
                'keahlian_id' => '1',
            ],
            [
                'mahasiswa_id' => '8',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '9',
                'keahlian_id' => '3',
            ],
            [
                'mahasiswa_id' => '10',
                'keahlian_id' => '1',
            ],
            [
                'mahasiswa_id' => '11',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '12',
                'keahlian_id' => '4',
            ],
            [
                'mahasiswa_id' => '13',
                'keahlian_id' => '5',
            ],
            [
                'mahasiswa_id' => '14',
                'keahlian_id' => '3',
            ],
            [
                'mahasiswa_id' => '15',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '16',
                'keahlian_id' => '1',
            ],
            [
                'mahasiswa_id' => '17',
                'keahlian_id' => '3',
            ],
            [
                'mahasiswa_id' => '18',
                'keahlian_id' => '2',
            ],
            [
                'mahasiswa_id' => '15',
                'keahlian_id' => '4',
            ],
        ]);
    }
}
