<?php

namespace App\Services;

class SawService
{
    public function hitung($mahasiswas, $bobots, $keahlianLomba = [])
    {
        // Validasi input
        if (empty($mahasiswas) || empty($bobots)) {
            throw new \InvalidArgumentException('Data mahasiswa dan bobot tidak boleh kosong');
        }

        // Validasi total bobot harus = 1
        $totalBobot = array_sum($bobots);
        if (abs($totalBobot - 1.0) > 0.001) {
            throw new \InvalidArgumentException('Total bobot harus sama dengan 1.0, saat ini: ' . $totalBobot);
        }

        $kriteria = ['score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'];
        
        // Hitung nilai maksimum untuk setiap kriteria
        $max = $this->hitungNilaiMaksimum($mahasiswas, $kriteria, $keahlianLomba);
        
        // Proses normalisasi dan perhitungan skor
        $hasil = [];
        foreach ($mahasiswas as $mhs) {
            $normal = $this->normalisasiNilai($mhs, $max, $keahlianLomba);
            $skor = $this->hitungSkorPreferensi($normal, $bobots, $kriteria);
            
            $hasil[] = [
                'mahasiswa' => $mhs,
                'skor_preferensi' => round($skor, 4),
                'ranking' => 0,
                'kriteria' => $normal,
                'detail_perhitungan' => $this->getDetailPerhitungan($normal, $bobots, $kriteria)
            ];
        }

        // Urutkan berdasarkan skor tertinggi dan berikan ranking
        return $this->urutkanDanBeriRanking($hasil);
    }

    private function hitungNilaiMaksimum($mahasiswas, $kriteria, $keahlianLomba)
    {
        $max = [];
        
        foreach ($kriteria as $k) {
            switch ($k) {
                case 'score':
                    $max[$k] = $mahasiswas->max('mahasiswa_score') ?: 1;
                    break;
                    
                case 'keahlian_utama':
                    // Untuk kriteria boolean, max = 1
                    $max[$k] = 1;
                    break;
                    
                case 'keahlian_tambahan':
                    $max[$k] = $mahasiswas->max('jumlah_keahlian_tambahan') ?: 1;
                    break;
                    
                case 'jumlah_lomba':
                    $max[$k] = $mahasiswas->max('jumlah_lomba') ?: 1;
                    break;
            }
        }
        
        return $max;
    }

    private function normalisasiNilai($mhs, $max, $keahlianLomba)
    {
        // Cek apakah keahlian utama mahasiswa sesuai dengan keahlian lomba
        $nilaiKeahlianUtama = empty($keahlianLomba) ? 1 : 
            (in_array($mhs->keahlian_utama_id, $keahlianLomba) ? 1 : 0);

        return [
            'score' => $this->normalisasi(
                floatval($mhs->mahasiswa_score ?? 0), 
                $max['score'], 
                'benefit'
            ),
            'keahlian_utama' => $this->normalisasi(
                $nilaiKeahlianUtama, 
                $max['keahlian_utama'], 
                'benefit'
            ),
            'keahlian_tambahan' => $this->normalisasi(
                floatval($mhs->jumlah_keahlian_tambahan ?? 0), 
                $max['keahlian_tambahan'], 
                'benefit'
            ),
            'jumlah_lomba' => $this->normalisasi(
                floatval($mhs->jumlah_lomba ?? 0), 
                $max['jumlah_lomba'], 
                'benefit'
            )
        ];
    }

    private function normalisasi($nilai, $nilaiMaks, $tipe = 'benefit')
    {
        // Hindari pembagian dengan nol
        if ($nilaiMaks == 0) {
            return 0;
        }

        if ($tipe === 'benefit') {
            // Untuk kriteria benefit (semakin besar semakin baik)
            return $nilai / $nilaiMaks;
        } else {
            // Untuk kriteria cost (semakin kecil semakin baik)
            return $nilaiMaks / $nilai;
        }
    }

    private function hitungSkorPreferensi($normal, $bobots, $kriteria)
    {
        $skor = 0;
        foreach ($kriteria as $k) {
            $bobot = $bobots[$k] ?? 0;
            $skor += $normal[$k] * $bobot;
        }
        return $skor;
    }

    private function getDetailPerhitungan($normal, $bobots, $kriteria)
    {
        $detail = [];
        foreach ($kriteria as $k) {
            $bobot = $bobots[$k] ?? 0;
            $detail[$k] = [
                'nilai_normal' => round($normal[$k], 4),
                'bobot' => $bobot,
                'hasil' => round($normal[$k] * $bobot, 4)
            ];
        }
        return $detail;
    }

    private function urutkanDanBeriRanking($hasil)
    {
        // Urutkan berdasarkan skor preferensi (tertinggi ke terendah)
        usort($hasil, function($a, $b) {
            return $b['skor_preferensi'] <=> $a['skor_preferensi'];
        });

        // Berikan ranking dengan penanganan skor yang sama
        $ranking = 1;
        for ($i = 0; $i < count($hasil); $i++) {
            if ($i > 0 && $hasil[$i]['skor_preferensi'] < $hasil[$i-1]['skor_preferensi']) {
                $ranking = $i + 1;
            }
            $hasil[$i]['ranking'] = $ranking;
        }

        return $hasil;
    }

    /**
     * Method tambahan untuk mendapatkan matriks keputusan
     */
    public function getMatriksKeputusan($mahasiswas, $keahlianLomba = [])
    {
        $matriks = [];
        foreach ($mahasiswas as $mhs) {
            $nilaiKeahlianUtama = empty($keahlianLomba) ? 1 : 
                (in_array($mhs->keahlian_utama_id, $keahlianLomba) ? 1 : 0);
                
            $matriks[] = [
                'mahasiswa_id' => $mhs->id,
                'nama' => $mhs->nama ?? 'N/A',
                'score' => floatval($mhs->mahasiswa_score ?? 0),
                'keahlian_utama' => $nilaiKeahlianUtama,
                'keahlian_tambahan' => floatval($mhs->jumlah_keahlian_tambahan ?? 0),
                'jumlah_lomba' => floatval($mhs->jumlah_lomba ?? 0)
            ];
        }
        return $matriks;
    }

    /**
     * Method untuk validasi konsistensi bobot
     */
    public function validasiBobot($bobots)
    {
        $totalBobot = array_sum($bobots);
        $kriteria = ['score', 'keahlian_utama', 'keahlian_tambahan', 'jumlah_lomba'];
        
        $validasi = [
            'valid' => true,
            'pesan' => [],
            'total_bobot' => $totalBobot
        ];

        // Cek total bobot
        if (abs($totalBobot - 1.0) > 0.001) {
            $validasi['valid'] = false;
            $validasi['pesan'][] = "Total bobot harus 1.0, saat ini: {$totalBobot}";
        }

        // Cek kelengkapan kriteria
        foreach ($kriteria as $k) {
            if (!isset($bobots[$k])) {
                $validasi['valid'] = false;
                $validasi['pesan'][] = "Bobot untuk kriteria '{$k}' tidak ditemukan";
            }
        }

        // Cek nilai bobot tidak negatif
        foreach ($bobots as $kriteria => $bobot) {
            if ($bobot < 0) {
                $validasi['valid'] = false;
                $validasi['pesan'][] = "Bobot untuk '{$kriteria}' tidak boleh negatif: {$bobot}";
            }
        }

        return $validasi;
    }
}