<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PdfSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_pdf_settings')->insert([
            [
                'pdf_instansi1' => 'STARS - Student Achievement Record System',
                'pdf_instansi2' => 'POLITEKNIK NEGERI MALANG',
                'pdf_alamat' => 'Jl. Soekarno-Hatta No. 9 Malang 65141',
                'pdf_telepon' => '(0341) 404424',
                'pdf_fax' => '(0341) 404420',
                'pdf_pes' => '101-105, 0341-404420',
                'pdf_website' =>  'www.polinema.ac.id',
            ],
        ]);
    }
}
