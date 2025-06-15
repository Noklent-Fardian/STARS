<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Verifikasi;

class HallOfFameController extends Controller
{
    public function index(Request $request)
    {
        // Get filter year
        $selectedYear = $request->get('year', 'all');
        
        // Get available years for filter
        $availableYears = DB::table('t_verifikasis')
            ->join('m_penghargaans', 't_verifikasis.penghargaan_id', '=', 'm_penghargaans.id')
            ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
            ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
            ->whereNotNull('t_verifikasis.verifikasi_verified_at')
            ->selectRaw('YEAR(t_verifikasis.verifikasi_verified_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Build base query for prestasi terbaru
        $prestasiQuery = DB::table('t_verifikasis')
            ->join('m_penghargaans', 't_verifikasis.penghargaan_id', '=', 'm_penghargaans.id')
            ->join('m_mahasiswas', 't_verifikasis.mahasiswa_id', '=', 'm_mahasiswas.id')
            ->join('m_prodis', 'm_mahasiswas.prodi_id', '=', 'm_prodis.id')
            ->join('m_lombas', 'm_penghargaans.lomba_id', '=', 'm_lombas.id')
            ->join('m_tingkatans', 'm_lombas.tingkatan_id', '=', 'm_tingkatans.id')
            ->join('m_peringkats', 'm_penghargaans.peringkat_id', '=', 'm_peringkats.id')
            ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
            ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
            ->where('m_lombas.lomba_terverifikasi', 1)
            ->whereNotNull('t_verifikasis.verifikasi_verified_at');

        // Apply year filter if selected
        if ($selectedYear !== 'all') {
            $prestasiQuery->whereRaw('YEAR(t_verifikasis.verifikasi_verified_at) = ?', [$selectedYear]);
        }

        // Get prestasi terbaru
        $prestasiTerbaru = $prestasiQuery
            ->select(
                'm_mahasiswas.mahasiswa_nama',
                'm_mahasiswas.mahasiswa_nim',
                'm_mahasiswas.mahasiswa_angkatan',
                'm_mahasiswas.mahasiswa_photo',
                'm_prodis.prodi_nama',
                'm_penghargaans.penghargaan_judul',
                'm_tingkatans.tingkatan_nama',
                'm_peringkats.peringkat_nama',
                't_verifikasis.verifikasi_verified_at',
                'm_penghargaans.penghargaan_score'
            )
            ->orderBy('t_verifikasis.verifikasi_verified_at', 'desc')
            ->limit(50)
            ->get();

        // Build query for top mahasiswa
        $mahasiswaQuery = DB::table('m_mahasiswas')
            ->join('m_prodis', 'm_mahasiswas.prodi_id', '=', 'm_prodis.id')
            ->where('m_mahasiswas.mahasiswa_visible', true);

        // Apply year filter for mahasiswa if selected
        if ($selectedYear !== 'all') {
            $mahasiswaQuery->whereExists(function ($query) use ($selectedYear) {
                $query->select(DB::raw(1))
                    ->from('t_verifikasis')
                    ->join('m_penghargaans', 't_verifikasis.penghargaan_id', '=', 'm_penghargaans.id')
                    ->whereColumn('t_verifikasis.mahasiswa_id', 'm_mahasiswas.id')
                    ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
                    ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
                    ->whereRaw('YEAR(t_verifikasis.verifikasi_verified_at) = ?', [$selectedYear]);
            });
        }

        $topMahasiswa = $mahasiswaQuery
            ->select(
                'm_mahasiswas.mahasiswa_nama',
                'm_mahasiswas.mahasiswa_nim',
                'm_mahasiswas.mahasiswa_angkatan',
                'm_mahasiswas.mahasiswa_photo',
                'm_mahasiswas.mahasiswa_score',
                'm_prodis.prodi_nama'
            )
            ->orderBy('m_mahasiswas.mahasiswa_score', 'desc')
            ->limit(50)
            ->get();

        // Build query for top dosen
        $dosenQuery = DB::table('m_dosens')
            ->where('m_dosens.dosen_visible', true);

        // Apply year filter for dosen if selected
        if ($selectedYear !== 'all') {
            $dosenQuery->whereExists(function ($query) use ($selectedYear) {
                $query->select(DB::raw(1))
                    ->from('t_verifikasis')
                    ->whereColumn('t_verifikasis.dosen_id', 'm_dosens.id')
                    ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
                    ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
                    ->whereRaw('YEAR(t_verifikasis.verifikasi_verified_at) = ?', [$selectedYear]);
            });
        }

        $topDosen = $dosenQuery
            ->select(
                'm_dosens.dosen_nama',
                'm_dosens.dosen_nip',
                'm_dosens.dosen_photo',
                'm_dosens.dosen_score'
            )
            ->orderBy('m_dosens.dosen_score', 'desc')
            ->limit(50)
            ->get();

        return view('hallOfFame', compact(
            'prestasiTerbaru',
            'topMahasiswa', 
            'topDosen',
            'availableYears',
            'selectedYear'
        ));
    }
}