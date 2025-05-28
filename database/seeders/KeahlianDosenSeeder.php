<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeahlianDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $data = [];

            foreach (range(1, 6) as $dosen_id) {
                $keahlianIds = collect(range(1, 25))->shuffle()->take(2);

                foreach ($keahlianIds as $keahlian_id) {
                    $data[] = [
                        'dosen_id' => $dosen_id,
                        'keahlian_id' => $keahlian_id,
                    ];
                }
            }

            DB::table('t_keahlian_dosens')->insert($data);
        }
    }
}