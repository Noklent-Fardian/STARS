<?php

namespace App\Services;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class TopsisService
{
    /**
     * Hitung rekomendasi mahasiswa dengan TOPSIS.
     * @return array $top5
     */
    public function hitungRekomendasi()
    {
        // 1. Ambil bobot kriteria dari tabel m_bobots
        $bobot = DB::table('m_bobots')->pluck('bobot', 'kriteria')->toArray();
        // ['score' => 0.4, 'keahlian_utama' => 0.3, 'keahlian_tambahan' => 0.2, 'jumlah_lomba' => 0.1]

        // 2. Ambil data mahasiswa beserta relasi yang dibutuhkan
        $mahasiswa = Mahasiswa::with(['keahliansTambahan', 'penghargaans'])->get();

        // 3. Siapkan matriks keputusan (decision matrix)
        $data = [];
        foreach ($mahasiswa as $m) {
            $data[] = [
                'id' => $m->id,
                'nama' => $m->mahasiswa_nama,
                // Kriteria 1: Score dari kolom mahasiswa_score
                'score' => $m->mahasiswa_score,
                // Kriteria 2: Keahlian utama dari kolom keahlian_id
                'keahlian_utama' => $m->keahlian_id,
                // Kriteria 3: Keahlian tambahan dari relasi t_keahlian_mahasiswas
                'keahlian_tambahan' => $m->keahliansTambahan->count(),
                // Kriteria 4: Banyaknya lomba yang diikuti dari relasi m_penghargaans
                'jumlah_lomba' => $m->penghargaans->count(),
            ];
        }

        // 4. Normalisasi matriks (setiap kolom dibagi akar jumlah kuadrat kolom tsb)
        $normalisasi = [];
        foreach (['score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'] as $kriteria) {
            $sumKuadrat = array_sum(array_map(fn($d) => pow($d[$kriteria], 2), $data));
            $akarSum = sqrt($sumKuadrat);
            foreach ($data as $i => $d) {
                $normalisasi[$i][$kriteria] = $akarSum == 0 ? 0 : $d[$kriteria] / $akarSum;
            }
            // Simpan id dan nama juga untuk referensi
            foreach ($data as $i => $d) {
                $normalisasi[$i]['id'] = $d['id'];
                $normalisasi[$i]['nama'] = $d['nama'];
            }
        }

        // 5. Matriks normalisasi terbobot (dikali bobot)
        $terbobot = [];
        foreach ($normalisasi as $i => $row) {
            foreach ($bobot as $kriteria => $bobotNilai) {
                $terbobot[$i][$kriteria] = $row[$kriteria] * $bobotNilai;
            }
            $terbobot[$i]['id'] = $row['id'];
            $terbobot[$i]['nama'] = $row['nama'];
        }

        // 6. Tentukan solusi ideal positif (A+) dan negatif (A-)
        $idealPositif = [];
        $idealNegatif = [];
        foreach ($bobot as $kriteria => $bobotNilai) {
            $kolom = array_column($terbobot, $kriteria);
            $idealPositif[$kriteria] = max($kolom);
            $idealNegatif[$kriteria] = min($kolom);
        }

        // 7. Hitung jarak ke solusi ideal positif dan negatif untuk setiap mahasiswa
        $jarakPositif = [];
        $jarakNegatif = [];
        foreach ($terbobot as $i => $row) {
            $jarakPositif[$i] = sqrt(array_sum(array_map(
                fn($kriteria) => pow($row[$kriteria] - $idealPositif[$kriteria], 2),
                array_keys($bobot)
            )));
            $jarakNegatif[$i] = sqrt(array_sum(array_map(
                fn($kriteria) => pow($row[$kriteria] - $idealNegatif[$kriteria], 2),
                array_keys($bobot)
            )));
        }

        // 8. Hitung nilai preferensi (V) untuk setiap mahasiswa
        $preferensi = [];
        foreach ($terbobot as $i => $row) {
            $v = ($jarakPositif[$i] + $jarakNegatif[$i]) == 0 ? 0 : $jarakNegatif[$i] / ($jarakPositif[$i] + $jarakNegatif[$i]);
            $preferensi[] = [
                'id' => $row['id'],
                'nama' => $row['nama'],
                'nilai' => $v,
            ];
        }

        // 9. Urutkan berdasarkan nilai preferensi (ranking tertinggi = rekomendasi utama)
        usort($preferensi, fn($a, $b) => $b['nilai'] <=> $a['nilai']);

        // 10. Ambil 5 besar rekomendasi
        $top5 = array_slice($preferensi, 0, 5);

        return $top5;
    }
}