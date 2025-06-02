<?php

namespace App\Services;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class TopsisService
{
    public function hitung($mahasiswas, $bobots, $keahlianLomba = [])
    {
        $matriks = [];
        foreach ($mahasiswas as $mahasiswa) {
            $nilaiKeahlianUtama = in_array($mahasiswa->keahlian_utama_id, $keahlianLomba) ? 1 : 0;
            $matriks[] = [
                'mahasiswa' => $mahasiswa,
                'score' => $mahasiswa->mahasiswa_score ?? 0,
                'keahlian_utama' => $nilaiKeahlianUtama,
                'keahlian_tambahan' => $mahasiswa->jumlah_keahlian_tambahan,
                'jumlah_lomba' => $mahasiswa->jumlah_lomba
            ];
        }

        $matriksNormal = $this->normalisasiMatriks($matriks);
        $matriksTerbobot = $this->hitungMatriksTerbobot($matriksNormal, $bobots);
        $solusiIdeal = $this->hitungSolusiIdeal($matriksTerbobot);
        $jarakIdeal = $this->hitungJarakIdeal($matriksTerbobot, $solusiIdeal);

        return $this->hitungSkorPreferensi($jarakIdeal, $matriks);
    }

    private function normalisasiMatriks($matriks)
    {
        $kriteria = ['score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'];
        $sumSquares = [];
        foreach ($kriteria as $k) {
            $sumSquares[$k] = sqrt(array_sum(array_map(function($row) use ($k) {
                return pow($row[$k], 2);
            }, $matriks)));
        }
        $matriksNormal = [];
        foreach ($matriks as $row) {
            $normalRow = ['mahasiswa' => $row['mahasiswa']];
            foreach ($kriteria as $k) {
                $normalRow[$k] = $sumSquares[$k] > 0 ? $row[$k] / $sumSquares[$k] : 0;
            }
            $matriksNormal[] = $normalRow;
        }
        return $matriksNormal;
    }

    private function hitungMatriksTerbobot($matriksNormal, $bobots)
    {
        $kriteria = ['score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'];
        $matriksTerbobot = [];
        foreach ($matriksNormal as $row) {
            $terbobotRow = ['mahasiswa' => $row['mahasiswa']];
            foreach ($kriteria as $k) {
                $bobot = $bobots[$k] ?? 0.25;
                $terbobotRow[$k] = $row[$k] * $bobot;
            }
            $matriksTerbobot[] = $terbobotRow;
        }
        return $matriksTerbobot;
    }

    private function hitungSolusiIdeal($matriksTerbobot)
    {
        $kriteria = ['score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'];
        $positif = [];
        $negatif = [];
        foreach ($kriteria as $k) {
            $values = array_column($matriksTerbobot, $k);
            $positif[$k] = max($values);
            $negatif[$k] = min($values);
        }
        return ['positif' => $positif, 'negatif' => $negatif];
    }

    private function hitungJarakIdeal($matriksTerbobot, $solusiIdeal)
    {
        $kriteria = ['score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'];
        $jarakPositif = [];
        $jarakNegatif = [];
        foreach ($matriksTerbobot as $index => $row) {
            $jPositif = 0;
            $jNegatif = 0;
            foreach ($kriteria as $k) {
                $jPositif += pow($row[$k] - $solusiIdeal['positif'][$k], 2);
                $jNegatif += pow($row[$k] - $solusiIdeal['negatif'][$k], 2);
            }
            $jarakPositif[$index] = sqrt($jPositif);
            $jarakNegatif[$index] = sqrt($jNegatif);
        }
        return ['positif' => $jarakPositif, 'negatif' => $jarakNegatif];
    }

    private function hitungSkorPreferensi($jarakIdeal, $matriks)
    {
        $hasil = [];
        foreach ($matriks as $index => $row) {
            $dPositif = $jarakIdeal['positif'][$index];
            $dNegatif = $jarakIdeal['negatif'][$index];
            $skorPreferensi = ($dPositif + $dNegatif) > 0 ? $dNegatif / ($dPositif + $dNegatif) : 0;
            $hasil[] = [
                'mahasiswa' => $row['mahasiswa'],
                'skor_preferensi' => round($skorPreferensi, 4),
                'ranking' => 0,
                'kriteria' => [
                    'score' => $row['score'],
                    'keahlian_utama' => $row['keahlian_utama'],
                    'keahlian_tambahan' => $row['keahlian_tambahan'],
                    'jumlah_lomba' => $row['jumlah_lomba']
                ]
            ];
        }
        usort($hasil, function($a, $b) {
            return $b['skor_preferensi'] <=> $a['skor_preferensi'];
        });
        foreach ($hasil as $index => &$item) {
            $item['ranking'] = $index + 1;
        }
        return $hasil;
    }
}