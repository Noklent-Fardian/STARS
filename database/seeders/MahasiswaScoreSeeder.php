<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all verified achievements and their scores
        $verifiedAchievements = DB::table('t_verifikasis as v')
            ->join('m_penghargaans as p', 'v.penghargaan_id', '=', 'p.id')
            ->join('m_lombas as l', 'p.lomba_id', '=', 'l.id')
            ->where('v.verifikasi_admin_status', 'Diterima')
            ->where('v.verifikasi_dosen_status', 'Diterima')
            ->where('l.lomba_terverifikasi', 1)
            ->select('v.mahasiswa_id', 'p.penghargaan_score')
            ->get();

        // Group by mahasiswa_id and calculate total scores
        $mahasiswaScores = [];
        foreach ($verifiedAchievements as $achievement) {
            if (!isset($mahasiswaScores[$achievement->mahasiswa_id])) {
                $mahasiswaScores[$achievement->mahasiswa_id] = 0;
            }
            $mahasiswaScores[$achievement->mahasiswa_id] += $achievement->penghargaan_score;
        }

        // Update each mahasiswa's score
        foreach ($mahasiswaScores as $mahasiswaId => $totalScore) {
            DB::table('m_mahasiswas')
                ->where('id', $mahasiswaId)
                ->update(['mahasiswa_score' => $totalScore]);
        }

        // Optional: Log the results for debugging
        echo "Updated mahasiswa scores:\n";
        foreach ($mahasiswaScores as $mahasiswaId => $score) {
            echo "Mahasiswa ID {$mahasiswaId}: {$score} points\n";
        }
    }
}