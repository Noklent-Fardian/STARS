<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        
        // Get top 10 newest verified achievements
        $top10NewVerifikasi = DB::table('t_verifikasis')
            ->join('m_penghargaans', 't_verifikasis.penghargaan_id', '=', 'm_penghargaans.id')
            ->join('m_mahasiswas', 't_verifikasis.mahasiswa_id', '=', 'm_mahasiswas.id')
            ->join('m_lombas', 'm_penghargaans.lomba_id', '=', 'm_lombas.id')
            ->join('m_tingkatans', 'm_lombas.tingkatan_id', '=', 'm_tingkatans.id')
            ->where('t_verifikasis.verifikasi_admin_status', 'Diterima')
            ->where('t_verifikasis.verifikasi_dosen_status', 'Diterima')
            ->where('m_lombas.lomba_terverifikasi', 1)
            ->whereNotNull('t_verifikasis.verifikasi_verified_at')
            ->select(
                'm_mahasiswas.mahasiswa_nama as mahasiswa_name',
                'm_penghargaans.penghargaan_judul as judul',
                'm_tingkatans.tingkatan_nama as tingkatan_name'
            )
            ->orderBy('t_verifikasis.verifikasi_verified_at', 'desc')
            ->limit(10)
            ->get();

        // Get top 10 students by score
        $top10mahasiswas = DB::table('m_mahasiswas')
            ->where('m_mahasiswas.mahasiswa_visible', true)
            ->select(
                'm_mahasiswas.mahasiswa_nama as name',
                'm_mahasiswas.mahasiswa_score as score'
            )
            ->orderBy('m_mahasiswas.mahasiswa_score', 'desc')
            ->limit(10)
            ->get();

        // Get top 10 lecturers by score
        $top10dosen = DB::table('m_dosens')
            ->where('m_dosens.dosen_visible', true)
            ->select(
                'm_dosens.dosen_nama as name',
                'm_dosens.dosen_score as score'
            )
            ->orderBy('m_dosens.dosen_score', 'desc')
            ->limit(10)
            ->get();

        return view('landing', compact(
            'banners',
            'top10NewVerifikasi',
            'top10mahasiswas',
            'top10dosen'
        ));
    }
    
    public function login()
    {
        return view('auth.login');
    }
}