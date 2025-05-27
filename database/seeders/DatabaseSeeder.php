<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            ProdiSeeder::class,
            SemesterSeeder::class,
            DosenSeeder::class,
            KeahlianSeeder::class,
            MahasiswaSeeder::class,
            TingkatanSeeder::class,
            LombaSeeder::class,
            PeringkatSeeder::class,
            PenghargaanSeeder::class,
            BimbinganSeeder::class,
            KeahlianLombaSeeder::class,
            KeahlianMahasiswaSeeder::class,
            KeahlianDosenSeeder::class,
            PenghargaanSeeder::class,
            TambahLombaSeeder::class,
            VerifikasiSeeder::class,
            PdfSettingSeeder::class,
            BannerSeeder::class,
            MovePublicFilesSeeder::class,
        ]);
    }
}
