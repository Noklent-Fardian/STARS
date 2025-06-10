<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenScoreSeeder extends Seeder
{
    public function run(): void
    {
        // Get all verified achievements and their scores
        $verifiedAchievements = DB::table('t_verifikasis as v')
            ->join('m_penghargaans as p', 'v.penghargaan_id', '=', 'p.id')
            ->join('m_lombas as l', 'p.lomba_id', '=', 'l.id')
            ->where('v.verifikasi_admin_status', 'Diterima')
            ->where('v.verifikasi_dosen_status', 'Diterima')
            ->where('l.lomba_terverifikasi', 1)
            ->select('v.dosen_id', 'p.penghargaan_score')
            ->get();

        // Group by dosen_id and calculate total scores
        $dosenScores = [];
        foreach ($verifiedAchievements as $achievement) {
            if (!isset($dosenScores[$achievement->dosen_id])) {
                $dosenScores[$achievement->dosen_id] = 0;
            }
            $dosenScores[$achievement->dosen_id] += $achievement->penghargaan_score;
        }

        // Update each dosen's score
        foreach ($dosenScores as $dosenId => $totalScore) {
            DB::table('m_dosens')
                ->where('id', $dosenId)
                ->update(['dosen_score' => $totalScore]);
        }

        // Optional: Log the results for debugging
        echo "Updated dosen scores:\n";
        foreach ($dosenScores as $dosenId => $score) {
            echo "Dosen ID {$dosenId}: {$score} points\n";
        }
    }
}