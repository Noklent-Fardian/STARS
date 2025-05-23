<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_banners')->insert([
            [
                'banner_nama' => 'Banner 1',
                'banner_link' => 'https://pimnas37.unair.ac.id',
                'banner_gambar' => 'banners/pimnas.png',
            ],
            [
                'banner_nama' => 'Banner 2',
                'banner_link' => 'https://www.instagram.com/kmipn2024_pnj/',
                'banner_gambar' => 'banners/kmipn.png',
            ],
            [
                'banner_nama' => 'Banner 3',
                'banner_link' => 'https://en.wikipedia.org/wiki/Google_Code_Jam',
                'banner_gambar' => 'banners/codejam.png',
            ],
            [
                'banner_nama' => 'Banner 4',
                'banner_link' => 'https://gemastik.kemdikbud.go.id/',
                'banner_gambar' => 'banners/gemastik.png',
            ],
            [
                'banner_nama' => 'Banner 5',
                'banner_link' => 'https://jti.polinema.ac.id/playit2024/',
                'banner_gambar' => 'banners/playit.png',
            ],
            [
                'banner_nama' => 'Banner 6',
                'banner_link' => 'https://lldikti6.kemdikbud.go.id/program-kreativitas-mahasiswa-pkm-5-bidang/',
                'banner_gambar' => 'banners/pkm.png',
            ],
            [
                'banner_nama' => 'Banner 7',
                'banner_link' => 'http://porseni.polinema.ac.id/',
                'banner_gambar' => 'banners/porseni.png',
            ],
            [
                'banner_nama' => 'Banner 8',
                'banner_link' => 'https://worldskills.org/',
                'banner_gambar' => 'banners/worldskill.png',
            ]
           
        ]);
    }
}
