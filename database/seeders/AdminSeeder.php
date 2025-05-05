<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_admins')->insert([
            [
                'user_id' => 1,
                'admin_name' => 'Danin, S.AP.',
                'admin_gender' => 'Laki-laki',
                'admin_nomor_telepon' => '085792079623',
            ],
            [
                'user_id' => 2,
                'admin_name' => 'Titis Octary Satrio, S.ST.',
                'admin_gender' => 'Perempuan',
                'admin_nomor_telepon' => '085790686586',
            ],
            [
                'user_id' => 3,
                'admin_name' => 'Ana Agustina, S.M.',
                'admin_gender' => 'Perempuan',
                'admin_nomor_telepon' => '085646492960',
            ],
            [
                'user_id' => 4,
                'admin_name' => 'Lailatul Qodriyah, S.Sos.',
                'admin_gender' => 'Perempuan',
                'admin_nomor_telepon' => '0812-3224-5969',
            ],
            [
                'user_id' => 5,
                'admin_name' => 'Sri Whariyanti, S.Pd.',
                'admin_gender' => 'Perempuan',
                'admin_nomor_telepon' => '083800666233',
            ]
        ]);
    }
}
